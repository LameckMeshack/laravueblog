<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index(Request $request)
    {

        // first check if you are logged in and admin user
        if (!Auth::check() && $request->path() != 'login') {

            return redirect('/login');
        }
        if (!Auth::check() && $request->path() == 'login') {

            return view('welcome');
        }

        //passed logged in .....now checking if admin
        $user = Auth::user();
        if ($user->userType == "User") {
            return redirect('/login');
        }

        if ($request->path() == 'login') {
            return redirect('/');
        }

        return view('welcome');
        return $request->path();
    }
    // Add tag
    public function addTag(Request $request)
    {
        // validate
        $this->validate($request, [
            'tagName' => 'required'
        ]);
        return Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    // Get all tags
    public function getTag()
    {
        return Tag::orderBy('id', 'desc')->get();
    }

    // Edit tag
    public function editTag(Request $request)
    {
        $this->validate($request, [
            'tagName' => 'required',
            'id' => 'required'
        ]);
        Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName
        ]);
        return response()->json([
            'tagName' => $request->tagName
        ]);
    }
    //upload category
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path("uploads"), $picName);
        return response()->json([
            'msg' => 'File uploaded successfully',
            'file' => $picName
        ]);
    }
    //delete image
    public function deleteImage(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName, false);
        return response()->json([
            'msg' => 'File deleted successfully',
        ]);
    }
    //delete file from the server
    public function deleteFileFromServer($fileName, $hasFullPath = false)
    {
        if (!$hasFullPath) {
            $filePath = public_path() . '/uploads/' . $fileName;
        }
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        return response()->json([
            'msg' => 'File deleted from the server successfully',
        ]);
    }
    // Delete tag
    public function deleteTag(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        Tag::where('id', $request->id)->delete();
        return response()->json(
            [
                'msg' => 'Tag deleted successfully'
            ]
        );
    }

    // categories
    //create category
    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required',
        ]);
        return Category::create([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage,
        ]);
    }

    // Get all categories
    public function getCategory()
    {
        return Category::orderBy('id', 'desc')->get();
    }

    // edit category
    public function editCategory(Request $request)
    {
        $this->validate($request, [

            'categoryName' => 'required',
            'iconImage' => 'required',
        ]);
        Category::where('id', $request->id)->update([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage

        ]);
    }

    // delete category
    public function deleteCategory(Request $request)
    {

        //delete original file from then serve
        $this->deleteFileFromServer($request->iconImage, true);

        $this->validate($request, [
            'id' => 'required'
        ]);
        Category::where('id', $request->id)->delete();
        return response()->json([
            'msg' => 'Category deleted successfully'
        ]);
    }

    //Users
    //Create user
    public function addUser(Request $request)
    {
        $this->validate($request, [
            'fullName' => 'required',
            'email' => 'bail|required|email:rfc,dns|unique:users,email',
            'password' => 'required|min:6',
            'userType' => 'required',
        ]);
        return User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'userType' => $request->userType,
        ]);
    }

    // Get all users
    public function getUser()
    {
        return User::where('userType', '!=', 'User')->get();
    }

    //Edit user
    public function editUser(Request $request)
    {
        $user = User::find($request->id);
        $this->validate($request, [
            'fullName' => 'required',
            'email' => [
                'required', 'email:rfc',
                Rule::unique("users")->ignore($user->id),
            ],
            'password' => 'min:6',
            'userType' => 'required',
        ]);
        $data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'userType' => $request->userType,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        return User::where('id', $request->id)->update(
            $data
        );
    }
    //roles
    //create role
    public function addRole(Request $request)
    {
        $this->validate($request, [
            'roleName' => 'required',
        ]);
        return Role::create([
            'roleName' => $request->roleName,
        ]);
    }

    // Get all roles
    public function getRole()
    {
        return Role::orderBy('id', 'desc')->get();
    }

    // edit role
    public function editRole(Request $request)
    {
        $this->validate($request, [
            'roleName' => 'required',
        ]);
        Role::where('id', $request->id)->update([
            'roleName' => $request->roleName,
        ]);
    }

    // delete role
    public function deleteRole(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        Role::where('id', $request->id)->delete();
        return response()->json([
            'msg' => 'Role deleted successfully'
        ]);
    }


    //login
    public function adminlogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|exists:users,email',
            'password' => 'bail|required|min:6',

        ], [
            'email.exists' => "Invalid credential"
        ]);

        //Attemp to login the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->role->isAdmin === 0) {
                Auth::logout();
                return response()->json([
                    'msg' => 'Invalid credentials'
                ], 401);
            }
            return response()->json([
                'msg' => 'You are logged in!',
                'user' => $user
            ]);
        } else {
            return response()->json([

                'msg' => 'Invalid credentials'
            ], 401);
        }
    }
    //login
    public function logout()
    {
        Auth::logout();
    }
}
