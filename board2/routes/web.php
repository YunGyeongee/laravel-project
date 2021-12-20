<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

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

Route::post('/login', 'App\Http\Controllers\MemberController@login');
Route::get('/logout', 'App\Http\Controllers\MemberController@logout');
Route::get('/members/{member}', 'App\Http\Controllers\MemberController@myPage');
Route::get('/main', 'App\Http\Controllers\MemberController@main');
Route::post('/members/{member}/nickUp', 'App\Http\Controllers\MemberController@nickUp');