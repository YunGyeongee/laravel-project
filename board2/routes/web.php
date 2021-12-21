<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

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