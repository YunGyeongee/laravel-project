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

Route::middleware('auth:api')->get('/members', function (Request $request) {
    return $request->member();
});

Route::get('members', 'App\Http\Controllers\MemberController@index');
//Route::get('members/{member}', 'App\Http\Controllers\MemberController@show');
Route::post('members/login', 'App\Http\Controllers\MemberController@login')->name('auth.login');
Route::get('members/create', 'App\Http\Controllers\MemberController@create');
Route::get('members/create2', 'App\Http\Controllers\MemberController@create');
Route::post('members/store', 'App\Http\Controllers\MemberController@store')->name('auth.join');

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('boards', 'App\Http\Controllers\BoardController@index')->name('main');
});