<?php

use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('index');
});

Route::get('/users/register', [UserController::class, 'registerIndex']);
Route::get('/users', [UserController::class, 'loginIndex']);

Route::get('/users/mypage', [UserController::class, 'mypageIndex']);

//Route::get('/boards', [BoardController::class, 'index'])->name('main');
