<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
}
