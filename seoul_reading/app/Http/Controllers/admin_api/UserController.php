<?php

namespace App\Http\Controllers\admin_api;

use App\Http\Controllers\Controller;
use App\Models\Administration_files;
use App\Models\Administrations;
use App\Models\Board_files;
use App\Models\Professor_files;
use App\Models\Professors;
use App\Models\Research_files;
use App\Models\Researches;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Users;
use App\Models\Member_counts;
use App\Models\Histories;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client as OClient;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * 관리자 로그인
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
            ], Response::HTTP_BAD_REQUEST);
        }

        $login_id = $request->input('login_id');
        $password = $request->input('password');

        if (Auth::attempt(['login_id' => $login_id, 'password' => $password, 'is_admin' => 1, 'status' => 0, 'is_deleted' => 0])) {
            $data = [];

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

            $user = auth()->user();

            $data['user_id'] = $user->id;
            $data['token'] = json_decode((string) $response->getBody(), true);

            return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
        }
    }

    /**
     *  교수진 관리 등록/수정
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function professor_make(Request $request)
    {
        $user = Auth()->user();

        $validator = Validator::make($request->all(), [
            'professor_name' => 'required',
            'research' => 'required',
            'professor_phone' => 'required',
            'professor_email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], Response::HTTP_BAD_REQUEST);
        }

        $target = $request->input('target');
        $professor_profile = $request->file('professor_profile');
        $professor_name = $request->input('professor_name');
        $research = $request->input('research');
        $professor_phone = $request->input('professor_phone');
        $professor_email = $request->input('professor_email');
        $career = $request->input('career');
        $site = $request->input('site');
        $created_by = $user->id;
        $updated_by = $user->id;

        // 연락처 특수문자 유효성 검사
        $pattern = "/[`~!@#$%^&*|\\\'\";:\/?^=^+_()<>]/";

        if(preg_match($pattern, $professor_phone)){
            return response()->json(['success' => false, 'alert' => '정상적인 번호가 아닙니다. 다시 입력해주세요.', 'data' => ''], 200);
        }

        // 파일(이미지) 업로드시 유효성 검사
        $fileTypeExt = explode("/", $_FILES['professor_profile']['type']);
        $fileType = $fileTypeExt[0];

        DB::beginTransaction();

        if ($target) {
            $update['professor_profile'] = $professor_profile;
            $update['professor_name'] = $professor_name;
            $update['research'] = $research;
            $update['professor_phone'] = $professor_phone;
            $update['professor_email'] = $professor_email;
            $update['career'] = $career;
            $update['site'] = $site;
            $update['updated_by'] = $user->id;

            $result = Professors::where('id', $target)->update($update);

            if ($result > 0) {
                if($professor_profile){
                    if($fileType == 'image'){
                        foreach($professor_profile as $file){
                            $file_name = $file->getClientOriginalName();
                            $original_name = time() . $file->getClientOriginalName(); // 원래 파일명
                            $file_url = url('/') . str_replace('public', 'storage', $file->storeAs("public/professor/$target/", $original_name));

                            $professor_files = new Professor_files();
                            $professor_files->professor_id = $target;
                            $professor_files->file_name = $file_name;
                            $professor_files->file_url = $file_url;
                            $professor_files->created_by = $created_by;
                            $professor_files->updated_by = $updated_by;
                            $result = $professor_files->save();

                            if($result > 0){

                            }else{
                                DB::rollBack();
                                return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
                            }
                        }
                    }else{
                        return response()->json(['success' => false, 'alert' => '이미지 파일이 아닙니다.', 'data' => ''], 200);
                    }
                }
                DB::commit();
                return response()->json(['success' => true, 'alert' => '', 'data' => $target], 200);
            } else {
                return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
            }
        } else {
            $professors = new Professors();
            $professors->professor_profile = $professor_profile;
            $professors->professor_name = $professor_name;
            $professors->research = $research;
            $professors->professor_phone = $professor_phone;
            $professors->professor_email = $professor_email;
            $professors->career = $career;
            $professors->site = $site;
            $professors->created_by = $created_by;
            $professors->updated_by = $updated_by;
            $result = $professors->save();

            if ($result > 0) {
                if($professor_profile){
                    if($fileType == 'image') {
                        foreach ($professor_profile as $file) {
                            $file_name = $file->getClientOriginalName();
                            $original_name = time() . $file->getClientOriginalName(); // 원래 파일명
                            $file_url = url('/') . str_replace('public', 'storage', $file->storeAs("public/professor/$professors->id/", $original_name));

                            $professor_files = new Professor_files();
                            $professor_files->professor_id = $professors->id;
                            $professor_files->file_name = $file_name;
                            $professor_files->file_url = $file_url;
                            $professor_files->created_by = $created_by;
                            $professor_files->updated_by = $updated_by;
                            $result = $professor_files->save();

                            if ($result > 0) {

                            } else {
                                DB::rollBack();
                                return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
                            }
                        }
                    }else{
                        return response()->json(['success' => false, 'alert' => '이미지 파일이 아닙니다.', 'data' => ''], 200);
                    }
                }
                DB::commit();
                return response()->json(['success' => true, 'alert' => '', 'data' => $professors->id], 200);
            } else {
                return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
            }
        }
    }

    /**
     * 교수진 관리 삭제
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function professor_delete(Request $request, Professors $professors)
    {
        $target = $request->input('target');
        $user = Auth()->user();

        $info = Professors::where('id', $target)->selectRaw('professors.updated_by')->first();

        if ($target) {
            $data['professors'] =
                Professors::where('id', $target)->first();

            if (empty($data['professors']['id'])) { // 데이터가 존재하지 않을 때
                return response()->json(['success' => false, 'alert' => '존재하지 않는 데이터 입니다. 다시 시도해주세요.', 'data' => ''], 200);
            } else if ($data['professors']['is_deleted'] > 0) { // 데이터가 삭제되었을 때
                return response()->json(['success' => false, 'alert' => '이미 삭제된 데이터 입니다.', 'data' => ''], 200);
            } else if ($user['id'] = $info) { // 본인이 작성한 데이터일 때
                $result = Professors::where('id', $target)->update(['is_deleted' => 1]);

                if ($result > 0) {
                    return response()->json(['success' => true, 'alert' => '정상적으로 삭제되었습니다.', 'data' => $result], 200);
                } else {
                    return response()->json(['success' => false, 'alert' => '오류가 발생하였습니다.', 'data' => ''], 200);
                }
            } else {
                return response()->json(['success' => false, 'alert' => '본인이 생성한 데이터가 아닙니다.', 'data' => ''], 200);
            }
        } else {
            return response()->json(['success' => false, 'alert' => '삭제할 데이터를 입력해주세요.', 'data' => ''], 200);
        }
    }

    /**
     * 연구분야 관리 등록/수정
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function research_make(Request $request)
    {
        $user = Auth()->user();

        $validator = Validator::make($request->all(), [
            'lab_name' => 'required',
            'professor_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], Response::HTTP_BAD_REQUEST);
        }

        $target = $request->input('target');
        $lab_name = $request->input('lab_name');
        $professor_name = $request->input('professor_name');
        $lab_info = $request->input('lab_info');
        $logo = $request->file('logo');
        $created_by = $user->id;
        $updated_by = $user->id;

        // 파일(이미지) 업로드시 유효성 검사
        $fileTypeExt = explode("/", $_FILES['logo']['type']);
        $fileType = $fileTypeExt[0];

        DB::beginTransaction();

        if ($target) {
            $update['lab_name'] = $lab_name;
            $update['professor_name'] = $professor_name;
            $update['lab_info'] = $lab_info;
            $update['logo'] = $logo;
            $update['updated_by'] = $user->id;

            $result = Researches::where('id', $target)->update($update);

            if ($result > 0) {
                if($logo){
                    if($fileType == 'image') {
                        foreach ($logo as $file) {
                            $file_name = $file->getClientOriginalName();
                            $original_name = time() . $file->getClientOriginalName(); // 원래 파일명
                            $file_url = url('/') . str_replace('public', 'storage', $file->storeAs("public/research/$target/", $original_name));

                            $research_files = new Research_files();
                            $research_files->lab_id = $target;
                            $research_files->file_name = $file_name;
                            $research_files->file_url = $file_url;
                            $research_files->created_by = $created_by;
                            $research_files->updated_by = $updated_by;
                            $result = $research_files->save();

                            if ($result > 0) {

                            } else {
                                DB::rollBack();
                                return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
                            }
                        }
                    }else{
                        return response()->json(['success' => false, 'alert' => '이미지 파일이 아닙니다.', 'data' => ''], 200);
                    }
                }
                DB::commit();
                return response()->json(['success' => true, 'alert' => '', 'data' => $target], 200);
            } else {
                return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
            }
        } else {
            $researches = new Researches();
            $researches->lab_name = $lab_name;
            $researches->professor_name = $professor_name;
            $researches->lab_info = $lab_info;
            $researches->logo = $logo;
            $researches->created_by = $created_by;
            $researches->updated_by = $updated_by;
            $result = $researches->save();

            if ($result > 0) {
                if($logo) {
                    if($fileType == 'image') {
                        foreach ($logo as $file) {
                            $file_name = $file->getClientOriginalName();
                            $original_name = time() . $file->getClientOriginalName(); // 원래 파일명
                            $file_url = url('/') . str_replace('public', 'storage', $file->storeAs("public/research/$researches->id/", $original_name));

                            $research_files = new Research_files();
                            $research_files->lab_id = $researches->id;
                            $research_files->file_name = $file_name;
                            $research_files->file_url = $file_url;
                            $research_files->created_by = $created_by;
                            $research_files->updated_by = $updated_by;
                            $result = $research_files->save();

                            if ($result > 0) {

                            } else {
                                DB::rollBack();
                                return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
                            }
                        }
                    }else{
                        return response()->json(['success' => false, 'alert' => '이미지 파일이 아닙니다.', 'data' => ''], 200);
                    }
                }
                DB::commit();
                return response()->json(['success' => true, 'alert' => '', 'data' => $researches->id], 200);
            } else {
                return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
            }
        }
    }

    /**
     * 연구분야 관리 삭제
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function research_delete(Request $request)
    {
        $target = $request->input('target');
        $user = Auth()->user();

        $info = Researches::where('id', $target)->selectRaw('researches.updated_by')->first();

        if ($target) {
            $data['researches'] =
                Researches::where('id', $target)->first();

            if (empty($data['researches']['id'])) { // 데이터가 존재하지 않을 때
                return response()->json(['success' => false, 'alert' => '존재하지 않는 데이터 입니다. 다시 시도해주세요.', 'data' => ''], 200);
            } else if ($data['researches']['is_deleted'] > 0) { // 데이터가 삭제되었을 때
                return response()->json(['success' => false, 'alert' => '이미 삭제된 데이터 입니다.', 'data' => ''], 200);
            } else if ($user['id'] = $info) { // 본인이 작성한 데이터일 때
                $result = Researches::where('id', $target)->update(['is_deleted' => 1]);

                if ($result > 0) {
                    return response()->json(['success' => true, 'alert' => '정상적으로 삭제되었습니다.', 'data' => ''], 200);
                } else {
                    return response()->json(['success' => false, 'alert' => '오류가 발생하였습니다.', 'data' => ''], 200);
                }
            } else {
                return response()->json(['success' => false, 'alert' => '본인이 생성한 데이터가 아닙니다.', 'data' => ''], 200);
            }

        } else {
            return response()->json(['success' => false, 'alert' => '삭제할 데이터를 입력해주세요.', 'data' => ''], 200);
        }
    }

    /**
     * 행정실 관리 등록/수정
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function administration_make(Request $request)
    {
        $user = Auth()->user();

        $validator = Validator::make($request->all(), [
            'administration_profile' => 'required',
            'administration_name' => 'required',
            'job' => 'required',
            'administration_phone' => 'required',
            'administration_email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], Response::HTTP_BAD_REQUEST);
        }

        $target = $request->input('target');
        $administration_profile = $request->file('administration_profile');
        $administration_name = $request->input('administration_name');
        $job = $request->input('job');
        $administration_phone = $request->input('administration_phone');
        $administration_email = $request->input('administration_email');
        $created_by = $user->id;
        $updated_by = $user->id;

        $pattern = "/[`~!@#$%^&*|\\\'\";:\/?^=^+_()<>]/";

        // 연락처 특수문자 유효성 검사
        if(preg_match($pattern, $administration_phone)){
            return response()->json(['success' => false, 'alert' => '정상적인 번호가 아닙니다. 다시 입력해주세요.', 'data' => ''], 200);
        }

        // 파일(이미지) 업로드시 유효성 검사
        $fileTypeExt = explode("/", $_FILES['administration_profile']['type']);
        $fileType = $fileTypeExt[0];

        DB::beginTransaction();

        if ($target) {
            $update['administration_profile'] = $administration_profile;
            $update['administration_name'] = $administration_name;
            $update['job'] = $job;
            $update['administration_phone'] = $administration_phone;
            $update['administration_email'] = $administration_email;
            $update['updated_by'] = $user->id;

            $result = Administrations::where('id', $target)->update($update);

            if ($result > 0) {
                if($fileType == 'image'){
                    foreach($administration_profile as $file){
                        $file_name = $file->getClientOriginalName();
                        $original_name = time() . $file->getClientOriginalName();
                        $file_url = url('/') . str_replace('public', 'storage', $file->storeAs("public/administration/$target/", $original_name));

                        $administration_files = new Administration_files();
                        $administration_files->adiministration_id = $target;
                        $administration_files->file_name = $file_name;
                        $administration_files->file_url = $file_url;
                        $administration_files->created_by = $created_by;
                        $administration_files->updated_by = $updated_by;
                        $result = $administration_files->save();

                        if($result > 0){

                        }else{
                            DB::rollBack();
                            return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
                        }
                    }
                }else{
                    return response()->json(['success' => false, 'alert' => '이미지 파일이 아닙니다.', 'data' => ''], 200);
                }
                DB::commit();
                return response()->json(['success' => true, 'alert' => '', 'data' => $target], 200);
            } else {
                return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
            }
        } else {
            $administrations = new Administrations();
            $administrations->administration_profile = $administration_profile;
            $administrations->administration_name = $administration_name;
            $administrations->job = $job;
            $administrations->administration_phone = $administration_phone;
            $administrations->administration_email = $administration_email;
            $administrations->created_by = $created_by;
            $administrations->updated_by = $updated_by;
            $result = $administrations->save();

            if ($result > 0) {
                if($fileType == 'image') {
                    foreach ($administration_profile as $file) {
                        $file_name = $file->getClientOriginalName();
                        $original_name = time() . $file->getClientOriginalName();
                        $file_url = url('/') . str_replace('public', 'storage', $file->storeAs("public/administration/$administrations->id/", $original_name));

                        $administration_files = new Administration_files();
                        $administration_files->adiministration_id = $administrations->id;
                        $administration_files->file_name = $file_name;
                        $administration_files->file_url = $file_url;
                        $administration_files->created_by = $created_by;
                        $administration_files->updated_by = $updated_by;
                        $result = $administration_files->save();

                        if ($result > 0) {

                        } else {
                            DB::rollBack();
                            return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
                        }
                    }
                }else{
                    return response()->json(['success' => false, 'alert' => '이미지 파일이 아닙니다.', 'data' => ''], 200);
                }
                DB::commit();
                return response()->json(['success' => true, 'alert' => '', 'data' => $administrations->id], 200);
            } else {
                return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
            }
        }
    }

    /**
     * 행정실 관리 삭제
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function administration_delete(Request $request)
    {
        $target = $request->input('target');
        $user = Auth()->user();

        $info = Administrations::where('id', $target)->selectRaw('administrations.updated_by')->first();

        if ($target) {
            $data['administrations'] =
                Administrations::where('id', $target)->first();

            if (empty($data['administrations']['id'])) { // 데이터가 존재하지 않을 때
                return response()->json(['success' => false, 'alert' => '존재하지 않는 데이터 입니다. 다시 시도해주세요.', 'data' => ''], 200);
            } else if ($data['administrations']['is_deleted'] > 0) { // 데이터가 삭제되었을 때
                return response()->json(['success' => false, 'alert' => '이미 삭제된 데이터 입니다.', 'data' => ''], 200);
            } else if ($user['id'] = $info) { // 본인이 작성한 데이터일 때
                $result = Administrations::where('id', $target)->update(['is_deleted' => 1]);

                if ($result > 0) {
                    return response()->json(['success' => true, 'alert' => '정상적으로 삭제되었습니다.', 'data' => ''], 200);
                } else {
                    return response()->json(['success' => false, 'alert' => '오류가 발생하였습니다.', 'data' => ''], 200);
                }
            } else {
                return response()->json(['success' => false, 'alert' => '본인이 생성한 데이터가 아닙니다.', 'data' => ''], 200);
            }
        }
    }
}
