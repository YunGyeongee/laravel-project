<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        $valid = validator($request->only('nickname'),[
            'nickname' => 'required|string'
        ]);

        if ($valid->fails()) {
            return response()->json([
                'error' => $valid->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }

        $nickname = $request->input('nickname');

        $user = DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['nickname' => $nickname]);

        $data = [];
        $data['data'] = $user;

        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
    }
}
