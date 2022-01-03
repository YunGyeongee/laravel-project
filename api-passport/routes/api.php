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
    Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');
    Route::post('/store', [BoardController::class, 'store'])->name('board.store');

    Route::group(['middleware' => ['auth:api']],function(){
//        Route::get('/info', [UserController::class, 'currentUserInfo'])->name('user.info');
        Route::get("/myPage", [UserController::class, 'index']);
    });
});
