<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * 현재 로그인 정보
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentUserInfo()
    {
        return response()->json([
            'user' => Auth::user()
        ], Response::HTTP_OK);
    }

    /**
     * 마이페이지
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth()->user();

        $data = [];
        $data['user'] = $user;
        $data['html'] = view('users.ajax.myPage', $data)->render();

        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
    }

    /**
     * 정보(닉네임) 수정
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validation = $request->validate([
            'nickname' => 'required'
        ]);

        $user = Auth::user()->id;
        $user -> nickname = $validation['nickname'];
        $user -> save();

        return response()->json(['success' => true, 'alert' => '', 'data' => $user], 200);
    }
}
