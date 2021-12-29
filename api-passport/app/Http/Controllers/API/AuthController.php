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

        // passport client 가져오기
        $client = Client::where('password_client', 1)->first();

        $http = new \GuzzleHttp\Client();

        $getTokenGenerateRoute = route('passport.token');

//        dd($getTokenGenerateRoute);

        $response = $http->post($getTokenGenerateRoute, [
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

        return response()->json([
           'user' => $user,
           'token' => $tokenResponse
        ], Response::HTTP_CREATED);

    }

    // 로그인 폼
    public function loginIndex()
    {
        return view('auth.login');
    }

    // 로그인
    public function login(Request $request)
    {
        $loginCredential = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        if(!Auth::attempt($loginCredential)) {
            return response()->json([
                'message' => '유효하지 않은 로그인 정보입니다.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $data = request()->only('email', 'password');

        // passport client 가져오기
        $client = Client::where('password_client', 1)->first();

        $http = new \GuzzleHttp\Client();

        $getTokenGenerateRoute = route('passport.token');

        $response = $http->post($getTokenGenerateRoute, [
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

        return response()->json([
            'user' => Auth::user(),
            'token' => $tokenResponse
        ], Response::HTTP_CREATED);
    }
}
