<?php

namespace App\Http\Controllers\Front\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Passport\Client as OClient;

class UserController extends Controller
{
    /**
     * 회원가입
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function register(Request $request)
    {
        $valid = validator($request->only('name', 'email', 'password', 'nickname'),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'nickname' => 'required'
        ]);

        if ($valid->fails()) {
            return response()->json([
                'error' => $valid->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }

        $data = request()->only('name', 'email', 'password', 'nickname');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'nickname' => $data['nickname'],
        ]);

        $client = OClient::where('password_client', 1)->first();

        $http = new \GuzzleHttp\Client();

        $url = env('APP_URL');

        $response = $http->post($url . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $data['email'],
                'password' => $data['password'],
                'scope' => '',
            ]
        ]);

        $tokenResponse = json_decode((string) $response->getBody(), true);

        $result = [];
        $result['user'] = $user;
        $result['token'] = $tokenResponse;

        return response()->json(['success' => true, 'alert' => '', 'data' => $result], 200);
    }

    /**
     * 로그인
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login(Request $request)
    {
        $loginCredential = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (!Auth::attempt($loginCredential)) {
            return response()->json(['success' => false, 'alert' => '로그인 정보가 없습니다.', 'data' => ''], 200);
        }

        $data = request()->only('email', 'password');

        $user = User::select('status')
            ->where([['email', $data['email']], ['status', 1]])
            ->first();

        if (!$user) {
            return response()->json(['success' => false, 'alert' => '존재하지 않는 회원 입니다.', 'data' => ''], 200);
        } else if ($user->status == 0){
            return response()->json(['success' => false, 'alert' => '탈퇴 회원입니다.', 'data' => ''], 200);
        } else {
            $client = OClient::where('password_client', 1)->first();

            $http = new \GuzzleHttp\Client();

            $url = env('APP_URL');

            $response = $http->post($url . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $client->id,
                    'client_secret' => $client->secret,
                    'username' => $data['email'],
                    'password' => $data['password'],
                    'scope' => '',
                ]
            ]);

            $tokenResponse = json_decode((string) $response->getBody(), true);

            $data = [];
            $data['user'] = $user;
            $data['token'] = $tokenResponse;

            return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
        }
    }

    /**
     * 로그아웃
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $user = Auth::user();

        $data = [];
        $data['user'] = $user->logout;

        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
    }

    /**
     * 마이페이지
     * @return \Illuminate\Http\JsonResponse
     */
    public function mypage()
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
