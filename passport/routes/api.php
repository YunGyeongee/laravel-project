<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BoardController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::prefix('/user')->group(function(){
    Route::post('/register', [AuthController::class, 'register'])->name('user.register');
    Route::post('/login', [AuthController::class, 'login'])->name('user.login');
    Route::post('/token-refresh', [AuthController::class, 'tokenRefresh'])->name('user.refresh');
    Route::post('/store', [BoardController::class, 'store'])->name('board.store');

    Route::group(['middleware' => ['auth:api']],function(){
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/myPage', [UserController::class, 'index']);
        Route::post('/myPage/update', [UserController::class, 'update']);

        Route::get('/boards/create', [BoardController::class, 'create']);
        Route::post('/boards/store', [BoardController::class, 'store']);
        Route::get('/boards/{board}/edit', [BoardController::class, 'edit']);
        Route::post('/boards/update', [BoardController::class, 'update']);
    });
});
