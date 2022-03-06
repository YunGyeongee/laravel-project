<?php

namespace App\Http\Controllers\admin_api;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use App\Models\Board_files;
use App\Models\Boards;
use App\Models\Page_contents;
use App\Models\Sites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class BoardController extends Controller
{
    /**
     * 배너 등록 / 수정
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function banner_make(Request $request)
    {
        $user = Auth()->user();

        $validator = Validator::make($request->all(), [
            'banner_name' => 'required',
            'banner_pc' => 'required',
            'banner_mobile' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], Response::HTTP_BAD_REQUEST);
        }

        $target = $request->input('target');
        $name = $request->input('banner_name');
        $pc = $request->file('banner_pc');
        $mobile = $request->file('banner_mobile');
        $url = $request->input('banner_url');
        $created_by = $user->id;
        $updated_by = $user->id;

        if ($target) {
            $update['banner_name'] = $name;
            $update['banner_pc'] = $pc;
            $update['banner_mobile'] = $mobile;
            $update['banner_url'] = $url;
            $update['updated_by'] = $user->id;

            $result = Banners::where('id', $target)->update($update);

            if ($result > 0) {
                return response()->json(['success' => true, 'alert' => '', 'data' => $target], 200);
            } else {
                return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
            }
        } else {
            $result = DB::table('banners')->count();

            if ($result < 5) { // 최대 5종 제한
                $banners = new Banners();
                $banners->banner_name = $name;
                $banners->banner_pc = $pc;
                $banners->banner_mobile = $mobile;
                $banners->banner_url = $url;
                $banners->created_by = $created_by;
                $banners->updated_by = $updated_by;
                $result = $banners->save();

                if ($result > 0) {
                    return response()->json(['success' => true, 'alert' => '', 'data' => $banners->id], 200);
                } else {
                    return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
                }
            } else {
                return response()->json(['success' => false, 'alert' => '배너를 더 이상 추가할 수 없습니다.', 'data' => ''], 200);
            }
        }
    }

    /**
     * 배너 삭제
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function banner_delete(Request $request)
    {
        $user = Auth()->user();
        $target = $request->input('target');

        $info = Banners::where('id', $target)->selectRaw('banners.updated_by')->first();

        if ($target) {
            $data['banners'] =
                Banners::where('id', $target)->first();

            if (empty($data['banners']['id'])) { // 데이터가 존재하지 않을 때
                return response()->json(['success' => false, 'alert' => '존재하지 않는 데이터 입니다. 다시 시도해주세요.', 'data' => ''], 200);
            } else if ($data['banners']['is_deleted'] > 0) { // 데이터가 삭제되었을 때
                return response()->json(['success' => false, 'alert' => '이미 삭제된 데이터 입니다.', 'data' => ''], 200);
            } else if ($user['id'] = $info) { // 본인이 작성한 데이터일 때
                $result = Banners::where('id',$target)->update(['is_deleted'=>1]);

                if($result > 0){
                    return response()->json(['success' => true, 'alert' => '정상적으로 삭제되었습니다.', 'data' => ''], 200);
                }else{
                    return response()->json(['success' => false, 'alert' => '일시적인 오류로 실패하였습니다. 다시 시도해주세요.', 'data' => ''], 200);
                }
            } else {
                return response()->json(['success' => false, 'alert' => '본인이 생성한 데이터가 아닙니다.', 'data' => ''], 200);
            }
        } else {
            return response()->json(['success' => false, 'alert' => '삭제할 데이터를 입력해주세요.', 'data' => ''], 200);
        }
    }
}
