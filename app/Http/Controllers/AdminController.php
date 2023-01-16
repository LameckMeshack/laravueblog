<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{

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
        $this->deleteFileFromServer($fileName);
        return response()->json([
            'msg' => 'File deleted successfully',
        ]);
    }
    //delete file from the server
    public function deleteFileFromServer($fileName)
    {
        $filePath = public_path() . '/uploads/' . $fileName;
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
            'iconImage' => $request->iconImage
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
            'id' => 'required',
            'name' => 'required'
        ]);
        Category::where('id', $request->id)->update([
            'categoryName' => $request->name
        ]);
    }

    // delete category
    public function deleteCategory(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        Category::where('id', $request->id)->delete();
        return response()->json([
            'msg' => 'Category deleted successfully'
        ]);
    }
}
