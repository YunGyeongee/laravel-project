<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UserManaController extends Controller
{
    /**
     * 관리자 메인페이지
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $user_status = $user->status;

        if ($user_status != 3) {
            echo '관리자가 아닙니다.';
            return view('/boards');
        }

        $data = [];
        $data['user'] = $user;
        $data['html'] = view('admin.ajax.home', $data)->render();

        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
    }

    /**
     * 회원 강제 탈퇴
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|string
     */
    public function editInfo(Request $request)
    {
        $user_id = $_POST['id'];

        $user = DB::table('users')
            ->where('id', $user_id)
            ->update(['status' => 0]);

        $login_info = Auth::user();
        $user_status = $login_info->status;

        if ($user_status != 3) {
            echo '관리자가 아닙니다.';
        } else {
            $data = [];
            $data['user'] = $user;

            return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
        }
    }
}
