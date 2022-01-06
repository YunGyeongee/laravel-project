<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    // 마이페이지
    public function index()
    {
        return view('users.myPage');
    }
}
