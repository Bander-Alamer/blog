<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('posts/{id}/comments','API\CommentController@store');
Route::get('posts/{id}/comments','API\CommentController@comments');

Route::put('posts/{id}','API\CommentController@updatePost');
Route::get('posts/{id}','API\CommentController@showPost');
Route::delete('/posts/{id}', 'PostsController@destroy')->name('posts.destroy');
