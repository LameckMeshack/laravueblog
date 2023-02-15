<?php

use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminCheck;
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

Route::prefix('/app')->middleware('admin')->group(function () {
    Route::post('/create_tag', 'AdminController@addTag');
    Route::get('/get_tags', 'AdminController@getTag');
    Route::post('/edit_tag', 'AdminController@editTag');
    Route::post('/delete_tag', 'AdminController@deleteTag');
    Route::post('/upload', 'AdminController@upload');
    Route::post('/delete_image', 'AdminController@deleteImage');

    // category
    Route::post('/create_category', 'AdminController@addCategory');
    Route::get('/get_categories', 'AdminController@getCategory');
    Route::post('/edit_category', 'AdminController@editCategory');
    Route::post('/delete_category', 'AdminController@deleteCategory');

    //user
    Route::post('/create_user', 'AdminController@addUser');
    Route::get('/get_users', 'AdminController@getUser');
    Route::post('/edit_user', 'AdminController@editUser');
    Route::post('/delete_user', 'AdminController@deleteUser');

    //admin
    Route::post('/admin_login', 'AdminController@adminlogin');
    // roles
    Route::post('/create_role', 'AdminController@addRole');
    Route::get('/get_roles', 'AdminController@getRole');
    Route::post('/edit_role', 'AdminController@editRole');
    Route::post('/delete_role', 'AdminController@deleteRole');
    Route::post('/assign_roles', 'AdminController@assignRole');
    //blog
    Route::post('/create_blog', 'AdminController@createBlog');
    Route::get('/get_blogs', 'AdminController@blogData');
    Route::get('/blog_single/{id}', 'AdminController@singleBlogItem');
    Route::post('/edit_blog/{id}', 'AdminController@editBlog');
    Route::post('/delete_blog', 'AdminController@deleteBlog');
});

Route::post('/createBlog', 'AdminController@uploadEditorImage');
Route::get('/blogdata', 'AdminController@blogData');
Route::get('/slug', 'AdminController@slug');




Route::post('/logout', 'AdminController@logout');
Route::any('/', 'AdminController@index');
// Route::any('{slug}', 'AdminController@index')->where('slug', '([A-z\d-\/_.]+)?');
Route::any('{slug}', 'AdminController@index');

// Route::get(
//     '/',
//     function () {
//         return view('welcome');
//     }
// );

// Route::any('{slug}', function () {
//     return view('welcome');
// });
