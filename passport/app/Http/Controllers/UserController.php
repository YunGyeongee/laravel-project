<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    /**
     * 마이페이지
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('users.myPage');
    }
}
