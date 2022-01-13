<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    /**
     * 회원가입 폼
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function registerIndex()
    {
        return view('users.ajax.register');
    }

    /**
     * 로그인 폼
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function loginIndex()
    {
        return view('users.ajax.login');
    }

    /**
     * 마이페이지
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function mypageIndex()
    {
        return view('users.myPage');
    }
}
