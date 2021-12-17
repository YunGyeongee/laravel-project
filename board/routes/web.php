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

Route::get('/boards', 'App\Http\Controllers\BoardController@index');
Route::get('/boards/create', 'App\Http\Controllers\BoardController@create');
Route::post('/boards', 'App\Http\Controllers\BoardController@store');
Route::get('/boards/{board}', 'App\Http\Controllers\BoardController@read');
Route::get('/boards/{board}/edit', 'App\Http\Controllers\BoardController@edit');
Route::put('/boards/{board}', 'App\Http\Controllers\BoardController@update');
Route::post('/boards/{board}', 'App\Http\Controllers\BoardController@destroy');
Route::post('/reply/store', 'App\Http\Controllers\ReplyController@store');