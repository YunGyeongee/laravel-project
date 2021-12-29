<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BoardController;
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

Route::get('/members/register', [AuthController::class, 'registerIndex']);
Route::get('/members', [AuthController::class, 'loginIndex']);
Route::get('/boards', [BoardController::class, 'index']);
