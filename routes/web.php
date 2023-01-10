<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\TestController;

//controller


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
    return view('welcome');
});



Route::post('app/create_tag', 'TestController@test');
Route::get(
    '/',
    function () {
        return view('welcome');
    }
);

Route::any('{slug}', function () {
    return view('welcome');
});
