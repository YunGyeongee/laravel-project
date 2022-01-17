<?php

use App\Http\Controllers\Admin\API\BoardManaController;
use App\Http\Controllers\Admin\API\HomeController;
use App\Http\Controllers\Admin\API\UserManaController;
use App\Http\Controllers\Front\API\BoardController;
use App\Http\Controllers\Front\API\ReplyController;
use App\Http\Controllers\Front\API\UserController;
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

        Route::get('/boards/create', [BoardController::class, 'create']);
        Route::post('/boards/store', [BoardController::class, 'store']);
        Route::get('/boards/{board}/edit', [BoardController::class, 'edit']);
        Route::post('/boards/{board}', [BoardController::class, 'update']);
        Route::post('/boards/{board}/destroy', [BoardController::class, 'destroy']);
        Route::post('/boards/{board}/replies/store', [ReplyController::class, 'store']);

        Route::get('/replies/{reply}/edit', [ReplyController::class, 'edit']);
        Route::post('/replies/{reply}', [ReplyController::class, 'update']);
        Route::post('/replies/{reply}/destroy', [ReplyController::class, 'destroy']);


        /* 관리자 */
        Route::get('/adminpage', [HomeController::class, 'index']);
        Route::post('/admin/destroy', [UserManaController::class, 'editInfo']);
        Route::get('/admin/boards/create', [BoardManaController::class, 'create']);
        Route::post('/admin/boards/store', [BoardManaController::class, 'store']);
    });
});
