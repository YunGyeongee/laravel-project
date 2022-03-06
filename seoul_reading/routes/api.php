<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('/user')->group(function() {

    //사용자 , 관리자 공통 ( * 타 프로젝트 진행시에는 분리 필요 )
    Route::post('/login', '\App\Http\Controllers\api\UserController@login'); // 로그인
    Route::post('/make', '\App\Http\Controllers\api\UserController@make'); // 회원가입
    Route::get('/mypage/view', '\App\Http\Controllers\api\UserController@my_page_view'); // 마이페이지 조회
    Route::post('/mypage/make', '\App\Http\Controllers\api\UserController@my_page_make'); // 개인 정보 수정

    Route::get('/banner/view', '\App\Http\Controllers\api\BoardController@banner_view'); // 배너 조회
    Route::get('/professor/view', '\App\Http\Controllers\api\UserController@professor_view'); // 교수진 조회
    Route::get('/research/view', '\App\Http\Controllers\api\UserController@research_view'); // 연구분야 조회
    Route::get('/administration/view', '\App\Http\Controllers\api\UserController@administration_view'); // 행정실 조회

    //관리자
    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/banner/make', '\App\Http\Controllers\admin_api\BoardController@banner_make'); // 배너 등록/수정
        Route::delete('/banner/delete', '\App\Http\Controllers\admin_api\BoardController@banner_delete'); // 배너 삭제

        Route::post('/professor/make', '\App\Http\Controllers\admin_api\UserController@professor_make'); // 교수진 조회
        Route::delete('/professor/delete', '\App\Http\Controllers\admin_api\UserController@professor_delete'); // 교수진 조회

        Route::post('/research/make', '\App\Http\Controllers\admin_api\UserController@research_make'); // 연구분야 조회
        Route::delete('/research/delete', '\App\Http\Controllers\admin_api\UserController@research_delete'); // 연구분야 조회

        Route::post('/administration/make', '\App\Http\Controllers\admin_api\UserController@administration_make'); // 행정실 조회
        Route::delete('/administration/delete', '\App\Http\Controllers\admin_api\UserController@administration_delete'); // 행정실 조회
    });
});
