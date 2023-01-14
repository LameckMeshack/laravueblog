<?php

namespace App\Http\Controllers;

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
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path("uploads"), $picName);
        return response()->json([
            'msg' => 'File uploaded successfully',
            'file' => $picName
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
}
