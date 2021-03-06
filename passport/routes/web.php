<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ReplyController;
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

Route::get('/users/register', [AuthController::class, 'registerIndex']);
Route::get('/users', [AuthController::class, 'loginIndex']);

Route::get('/boards', [BoardController::class, 'index'])->name('main');
Route::get('/boards/create', [BoardController::class, 'create']);
Route::get('/boards/{board}', [BoardController::class, 'read']);
Route::get('/boards/{board}/edit', [BoardController::class, 'edit']);

Route::get('/users/mypage', [UserController::class, 'index']);

Route::get('/replies/{reply}/edit', [ReplyController::class, 'edit']);
