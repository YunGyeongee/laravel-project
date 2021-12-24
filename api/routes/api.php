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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', 'UserController@login')->name('main');
Route::post('users/update', 'UserController@myUpdate');

Route::post('/register', 'RegisterController@store');

Route::post('boards/store', 'BoardController@store');
Route::post('boards/{board}', 'BoardController@update');
Route::post('boards/{board}', 'BoardController@destroy');

Route::post('replies/store', 'ReplyController@store');
Route::post('replies/{reply}', 'ReplyController@update');

