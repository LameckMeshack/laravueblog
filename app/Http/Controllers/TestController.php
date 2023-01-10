<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function controllerMethod()
    {
        return view('welcome');
    }

    public function test()
    {
        return response()->json(
            [
                'message' => 'Error occurres',

            ],
            422
        );
    }
}
