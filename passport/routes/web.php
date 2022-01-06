<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BoardController;
use App\Http\Controllers\API\UserController;
use App\Models\Board;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    $boards = Board::select('id', 'title', 'content', 'created_at')
        ->where('status', 0)
        ->orderBy('id', 'desc')
        ->get();

    dd(compact('boards'));

    print_r($boards);
    echo "<br><br>";
    print_r(compact('boards'));
    die;

    return view('main', compact('boards'));

    die;
    return view('index');
});

Route::get('/users/register', [AuthController::class, 'registerIndex']);
Route::get('/users', [AuthController::class, 'loginIndex']);

Route::get('/boards', [BoardController::class, 'index'])->name('main');
Route::get('/myPage2', [UserController::class, 'myPage']);

Route::get('/users/mypage', [\App\Http\Controllers\UserController::class, 'index']);
