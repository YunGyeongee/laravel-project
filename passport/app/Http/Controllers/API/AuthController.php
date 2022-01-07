<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Client as OClient;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    // 회원가입
    public function register(Request $request)
    {
        $valid = validator($request->only('email', 'name', 'password'),[
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6'
        ]);

        if ($valid->fails()) {
            return response()->json([
                'error' => $valid->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }

        $data = request()->only('email', 'name', 'password');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'status' => 0
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

        $result_data = [];
        $result_data['user'] = $user;
        $result_data['token'] = $tokenResponse;

        return response()->json(['success' => true, 'alert' => '', 'data' => $result_data], 200);

    }

    // 로그인
    public function login(Request $request)
    {

        $loginCredential = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($loginCredential)) {
            return '로그인 정보가 없습니다.';
        }

        $data = request()->only('email', 'password');

        // passport client 가져오기
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

        $result_data = [];
        $result_data['token'] = $tokenResponse;

        return response()->json(['success' => true, 'alert' => '', 'data' => $result_data], 200);
    }

    // 리프레시 토큰 받아서 액세스 토큰 새로 고침
    public function tokenRefresh(Request $request)
    {
        $userRequest = validator($request->only('refresh_token'),[
            'refresh_token' => 'required',
        ]);

        if ($userRequest->fails()) {
            return response()->json([
                'error' => $userRequest->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }

        $data = request()->only('refresh_token');

        $client = OClient::where('password_client', 1)->first();

        $url = env('APP_URL');

        $response = Http::asForm() -> post($url . '/oauth/token', [
                'grant_type' => 'refresh_token',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'refresh_token' => $data['refresh_token'],
                'scope' => '',
        ]);

        $tokenResponse = $response->json();

        if (isset($tokenResponse['error'])) {
            return response()->json([
                'message' => '토큰 에러',
                'error' => $tokenResponse['error']
            ], Response::HTTP_UNAUTHORIZED);
        } else {
            return response()->json([
                'message' => '토큰 재발행 완료',
                'token' => $tokenResponse
            ], Response::HTTP_OK);
        }
    }

    // 로그아웃
    public function logout()
    {
        if (Auth::check()) {
            $token = Auth::user()->token();
            $token->revoke();
            return view('index');
        } else {
            return '정상적으로 로그아웃 되지 않았습니다.';
        }
    }
}
