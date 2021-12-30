<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    // 회원가입 폼
    public function registerIndex()
    {
        return view('auth/register');
    }

    // 회원가입
    public function register(Request $request)
    {
        $valid = validator($request->only('email', 'name', 'password'),[
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6'
        ]);

        // 필수 입력값들에 대한 유효성 검사
        if($valid->fails()) {
            return response()->json([
                'error' => $valid->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }

        $data = request()->only('email', 'name', 'password');

        // 사용자 생성
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return view('auth.login');

    }

    // 로그인 폼
    public function loginIndex()
    {
        return view('auth.login');
    }

    // 로그인
    public function login(Request $request)
    {
        $loginUser = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(auth()->attempt($loginUser)) { // 로그인 성공
//            $userLoginToken = auth()->user()->createToken('PassportExample@Section.io')->accessToken;
            return view('main');
        } else { // 로그인 실패
            return redirect()->back();
        }

    }

    // 로그아웃
    public function logout()
    {
        if(Auth::check()) {
            $token = Auth::user()->token();
            $token->revoke();
            return view('index');
        } else {
            return '정상적으로 로그아웃 되지 않았습니다.';
        }
    }
}
