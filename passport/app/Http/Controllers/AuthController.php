<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Client as OClient;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * 회원가입 폼
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function registerIndex()
    {
        return view('auth.ajax.register');
    }

    /**
     * 로그인 폼
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function loginIndex()
    {
        return view('auth.ajax.login');
    }
}
