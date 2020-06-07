<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/contact', function () {
//     return "contact page";
// });

// Route::get('/posts/{name}/{id}', function ($name, $id) {
//     return "This is post's name: $name, witch his id is $id";
// });

// // Naming routes
// Route::get('/admin/posts/edit', ['as' => 'admin.edit', function () {
//     $url = route('admin.edit');
//     return "This url is $url";
// }]);

// Route::get('admin/posts/{id}', 'PostsController@index');

Route::resource('posts','PostsController');

Route::get('/contact', 'PostsController@contact');

Route::get('/post/{id}/{title}', 'PostsController@post');

