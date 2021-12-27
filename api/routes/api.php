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
Route::get('members/login', 'App\Http\Controllers\MemberController@login');

Route::get('boards', 'App\Http\Controllers\BoardController@index')->name('main');