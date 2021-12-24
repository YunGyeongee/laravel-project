<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controller\UserController;
use App\Http\Controller\RegisterController;
use App\Http\Controller\BoardController;
use App\Http\Controller\ReplyController;

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
    return view('index');
});

Route::get('auth/login', 'App\Http\Controller\UserController@index');
Route::get('auth/logout', 'App\Http\Controller\UserController@logout');
Route::get('users/myPage', 'App\Http\Controller\UserController@myIndex');

Route::get('/register', 'App\Http\Controller\RegisterController@index');

Route::get('boards', 'App\Http\Controller\BoardController@index')->name('boardMain');
Route::get('boards/create', 'App\Http\Controller\BoardController@create');
Route::get('boards/{board}', 'App\Http\Controller\BoardController@read');
Route::get('boards/{board}/edit', 'App\Http\Controller\BoardController@edit');

Route::get('replies/{reply}/edit', 'App\Http\Controller\ReplyController@edit');
Route::get('replies/destroy', 'App\Http\Controller\ReplyController@destroy');
