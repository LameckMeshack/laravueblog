<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{
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

    public function getTag()
    {
        return Tag::orderBy('id', 'desc')->get();
    }
    public function editTag(Request $request)
    {
        $this->validate($request, [
            'tagName' => 'required',
            'id' => 'required'
        ]);
        Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName
        ]);
        // return response()->json([
        //     'tagName' => $request->tagName
        // ]);
    }
}
