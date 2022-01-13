<?php

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

Route::prefix('/user')->group(function() {
    Route::post('/register', [UserController::class, 'register'])->name('user.register');
    Route::post('/login', [UserController::class, 'login'])->name('user.login');

    Route::group(['middleware' => ['auth:api']],function(){
        Route::post('/logout', [UserController::class, 'logout']);

        Route::get('/myPage', [UserController::class, 'mypage']);
        Route::post('/myPage/update', [UserController::class, 'update']);

    });
});
