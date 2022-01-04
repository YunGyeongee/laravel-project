<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    // 현재 로그인 정보
    public function currentUserInfo()
    {
        return response()->json([
            'user' => Auth::user()
        ], Response::HTTP_OK);
    }

    // 마이페이지
    public function index()
    {
        return view('users.myPage');
    }

    // 정보(닉네임) 수정
    public function update(Request $request)
    {
        $validation = $request-> validate([
            'nickname' => 'required'
        ]);

        $user = User::find(Auth::user()->id);
        $user -> nickname = $validation['nickname'];
        $user -> save();

        return redirect()->back();
    }
}
