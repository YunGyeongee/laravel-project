<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Boards;
use App\Models\Board_files;
use App\Models\Sites;
use App\Models\Page_contents;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class BoardController extends Controller
{
    /**
     * 배너 조회
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function banner_view(Request $request){
        $target = $request->input('target');

        if($target){
            $data['banner'] =
                Banners::where('id',$target)->first();

            if($data['banner']['is_deleted'] > 0){ // 데이터가 삭제되었을 때
                return response()->json(['success' => false, 'alert' => '삭제된 데이터 입니다.', 'data' => ''], 200);
            } else if(empty($data['banner'])){ // 데이터가 존재하지 않을 때
                return response()->json(['success' => false, 'alert' => '조회된 데이터가 없습니다.', 'data' => ''], 200);
            }
        }else{
            $data['list'] =
                Banners::where('is_deleted',0)->orderBy('created_at','ASC')->get();
        }
        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);

    }
}



