<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BoardController;


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

Route::middleware('auth:api')->get('/members', function (Request $request) {
    return $request->member();
});

Route::get('members', 'App\Http\Controllers\MemberController@index');
Route::get('members/{member}', 'App\Http\Controllers\MemberController@show');
Route::post('members/login', 'App\Http\Controllers\MemberController@login')->name('login');
Route::get('members/create', 'App\Http\Controllers\MemberController@create');
Route::post('members/store', 'App\Http\Controllers\MemberController@store')->name('join');

Route::get('boards', 'App\Http\Controllers\BoardController@index')->name('main');
Route::get('boards/create', 'App\Http\Controllers\BoardController@create');
Route::post('boards/store', 'App\Http\Controllers\BoardController@store');
Route::get('boards/{board}', 'App\Http\Controllers\BoardController@show');
Route::get('boards/{board}/edit', 'App\Http\Controllers\BoardController@edit');
Route::post('boards/{board}', 'App\Http\Controllers\BoardController@update');
Route::get('boards', 'App\Http\Controllers\BoardController@destroy');