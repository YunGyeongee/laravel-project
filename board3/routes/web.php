<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Front\BoardController;
use App\Http\Controllers\Front\ReplyController;
use App\Http\Controllers\Front\UserController;
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

Route::get('/boards', [BoardController::class, 'index'])->name('main');
Route::get('/boards/create', [BoardController::class, 'create']);
Route::get('/boards/{board}', [BoardController::class, 'read']);
Route::get('/boards/{board}/edit', [BoardController::class, 'edit']);

Route::get('/replies/{reply}/edit', [ReplyController::class, 'edit']);


/* 관리자 */
Route::get('/admin', [HomeController::class, 'index']);
Route::get('/admin/users', [HomeController::class, 'userList']);
Route::get('/admin/users/{user}', [HomeController::class, 'detail']);
