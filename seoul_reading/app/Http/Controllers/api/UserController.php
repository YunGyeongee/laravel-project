<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Administrations;
use App\Models\Professors;
use App\Models\Researches;
use App\Models\Users;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Member_counts;
use App\Models\Histories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client as OClient;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Exception\BadResponseException;

class UserController extends Controller
{
    /**
     * 회원가입
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function make(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_id' => 'required|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }

        $login_id = $request->input('login_id');
        $password = $request->input('password');

        $users = new Users();
        $users->login_id = $login_id;
        $users->password = bcrypt($password);
        $result = $users->save();

        if($result > 0){
            return response()->json(['success' => true, 'alert' => '', 'data' => $result], 200);
        }else{
            return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
        }
    }

    /**
     * 로그인
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_id' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }

        $login_id = $request->input('login_id');
        $password = $request->input('password');

        if (Auth::attempt(['login_id' => $login_id, 'password' => $password, 'status' => 0, 'is_deleted' => 0])) {
            $data = [];
            $data['type'] = 'join';

            $oClient = OClient::where('password_client', 1)->first();

            try {
                $http = new Client();
                $url = env('APP_URL');
                $response = $http->post($url . '/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => $oClient->id,
                        'client_secret' => $oClient->secret,
                        'username' => $login_id,
                        'password' => $password,
                        'scope' => '',
                    ],
                ]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => $e->getCode()], 200);
            }

            $data['token'] = json_decode((string) $response->getBody(), true);

            return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
        }
    }

    /**
     * 마이페이지 회원 정보 조회
     * @return \Illuminate\Http\JsonResponse
     */
    public function my_page_view(Request $request)
    {
        $target = $request->input('target');

        if($target) {
            $data['users'] =
                Users::where('id', $target)->first();

            if ($data['users']['is_deleted'] > 0) { // 데이터가 삭제되었을 때
                return response()->json(['success' => false, 'alert' => '탈퇴한 회원 입니다.', 'data' => ''], 200);
            } else if (empty($data['users'])) { // 데이터가 존재하지 않을 때
                return response()->json(['success' => false, 'alert' => '조회된 회원이 없습니다.', 'data' => ''], 200);
            }
        }else{
            $data['lists'] =
                Users::orderBy('id','ASC')->get();
        }
        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
    }

    /**
     * 마이페이지 회원 정보 수정
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function my_page_make(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'target' => 'required',
            'login_id' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }

        $target = $request->input('target');
        $login_id = $request->input('login_id');
        $password = $request->input('password');

        if ($target) {
            $data['users'] =
                Users::where('id', $target)->first();

            if(empty($data['users']['id'])){ // 데이터가 존재하지 않을 때
                return response()->json(['success' => false, 'alert' => '존재하지 않는 회원입니다.', 'data' => ''], 200);
            }else{
                $update['login_id'] = $login_id;
                $update['password'] = $password;

                $result = Users::where('id', $target)->update($update);

                if($result > 0) {
                    return response()->json(['success' => true, 'alert' => '', 'data' => $result], 200);
                } else {
                    return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
                }
            }
        } else {
            return response()->json(['success' => false, 'alert' => '변경할 데이터가 없습니다. 다시 시도해주세요.', 'data' => ''], 200);
        }
    }

    /**
     * 교수진 조회
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function professor_view(Request $request)
    {
        $target = $request->input('target');

        if($target){
            $data['professors'] =
                Professors::where('id',$target)->first();

            if($data['professors']['is_deleted'] > 0){ // 데이터가 삭제되었을 때
                return response()->json(['success' => false, 'alert' => '삭제된 데이터 입니다.', 'data' => ''], 200);
            } else if(empty($data['professors'])){ // 데이터가 존재하지 않을 때
                return response()->json(['success' => false, 'alert' => '조회된 데이터가 없습니다.', 'data' => ''], 200);
            }

        }else{
            $data['lists'] =
                Professors::where('is_deleted',0)->orderBy('created_at','ASC')->get();
        }
        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
    }

    /**
     * 연구분야 조회
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function research_view(Request $request)
    {
        $target = $request->input('target');

        if($target){
            $data['researches'] =
                Researches::where('id',$target)->first();

            if($data['researches']['is_deleted'] > 0){ // 데이터가 삭제되었을 때
                return response()->json(['success' => false, 'alert' => '삭제된 데이터 입니다.', 'data' => ''], 200);
            } else if(empty($data['researches'])){ // 데이터가 존재하지 않을 때
                return response()->json(['success' => false, 'alert' => '조회된 데이터가 없습니다.', 'data' => ''], 200);
            }
        }else{
            $data['lists'] =
                Researches::where('is_deleted',0)->orderBy('created_at','ASC')->get();
        }
        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
    }

    /**
     * 행정실 조회
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function administration_view(Request $request)
    {
        $target = $request->input('target');

        if($target){
            $data['administrations'] =
                Administrations::where('id',$target)->first();

            if($data['administrations']['is_deleted'] > 0){ // 데이터가 삭제되었을 때
                return response()->json(['success' => false, 'alert' => '삭제된 데이터 입니다.', 'data' => ''], 200);
            } else if(empty($data['administrations'])){ // 데이터가 존재하지 않을 때
                return response()->json(['success' => false, 'alert' => '조회된 데이터가 없습니다.', 'data' => ''], 200);
            }
        }else{
            $data['lists'] =
                Administrations::where('is_deleted',0)->orderBy('created_at','ASC')->get();
        }
        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
    }
}
