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



Route::post('app/create_tag', 'AdminController@addTag');
Route::get('app/get_tags', 'AdminController@getTag');
Route::post('app/edit_tag', 'AdminController@editTag');
Route::post('app/delete_tag', 'AdminController@deleteTag');
Route::post('app/upload', 'AdminController@upload');
Route::post('app/delete_image', 'AdminController@deleteImage');

// category
Route::post('app/create_category', 'AdminController@addCategory');
Route::get('app/get_categories', 'AdminController@getCategory');
Route::post('app/edit_category', 'AdminController@editCategory');
Route::post('app/delete_category', 'AdminController@deleteCategory');

//user
Route::post('app/create_user', 'AdminController@addUser');
Route::get('app/get_users', 'AdminController@getUser');
Route::post('app/edit_user', 'AdminController@editUser');
Route::post('app/delete_user', 'AdminController@deleteUser');

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);

Route::any('{slug}', function () {
    return view('welcome');
});
