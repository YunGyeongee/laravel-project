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
Route::post('/boards/reply', 'App\Http\Controllers\ReplyController@store');
Route::get('/boards', 'App\Http\Controllers\BoardController@index');
Route::get('/boards2', 'App\Http\Controllers\BoardController@index');
Route::get('/boards/create', 'App\Http\Controllers\BoardController@create');
Route::post('/boards', 'App\Http\Controllers\BoardController@store');
Route::get('/boards/{board}', 'App\Http\Controllers\BoardController@read');
Route::get('/boards/{board}/edit', 'App\Http\Controllers\BoardController@edit');
Route::post('/boards/{board}', 'App\Http\Controllers\BoardController@update');
Route::post('/boards/{board}', 'App\Http\Controllers\BoardController@destroy');
