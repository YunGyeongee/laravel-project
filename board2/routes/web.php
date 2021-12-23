<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ReplyController;

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

Route::get('auth/login', 'App\Http\Controllers\LoginController@index');
Route::post('auth/login', 'App\Http\Controllers\LoginController@login')->name('main');
Route::get('auth/logout', 'App\Http\Controllers\LoginController@logout');

Route::get('/register', 'App\Http\Controllers\RegisterController@index');
Route::post('/register', 'App\Http\Controllers\RegisterController@store');

Route::get('users/myPage', 'App\Http\Controllers\LoginController@myIndex');
Route::post('users/update', 'App\Http\Controllers\LoginController@myUpdate');

Route::get('boards', 'App\Http\Controllers\BoardController@index')->name('boardMain');
Route::get('boards/create', 'App\Http\Controllers\BoardController@create');
Route::post('boards/store', 'App\Http\Controllers\BoardController@store');
Route::get('boards/{board}', 'App\Http\Controllers\BoardController@read');
Route::get('boards/{board}/edit', 'App\Http\Controllers\BoardController@edit');
Route::post('boards/{board}', 'App\Http\Controllers\BoardController@update');
Route::post('boards/{board}', 'App\Http\Controllers\BoardController@destroy');

Route::post('replies/store', 'App\Http\Controllers\ReplyController@store');
Route::get('replies/{reply}/edit', 'App\Http\Controllers\ReplyController@edit');
Route::post('replies/{reply}', 'App\Http\Controllers\ReplyController@update');
Route::post('replies/{reply}/destroy', 'App\Http\Controllers\ReplyController@destroy');