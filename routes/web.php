<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckGender;
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

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home')->middleware([checkGender::class]);


Route::post('posts/{id}/comments','CommentController@store');
Route::get('/posts','PostController@index')->name('posts');
        Route::get('/posts/create','PostController@create')->name("showCreatePost")->middleware([checkGender::class]);
            Route::get('/posts/{id}','PostController@show')->name('showPost');
            Route::post('/posts/create','PostController@store')->name('createPost');


            Route::get('/fillGender', "HomeController@genderIndex")->name('show-fillGender');
            Route::match(['put', 'patch'], '/fillGender', "HomeController@genderUpdate")->name('fillGender');

            Route::delete('/posts/{id}', 'PostController@destroy')->name('posts.destroy');
