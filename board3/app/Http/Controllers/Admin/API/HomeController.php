<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        var_dump($user); die;

        if ($user->status != 3) {
            return response()->json(['success' => false, 'alert' => '관리자 권한이 없습니다.', 'data' => ''], 200);
        }

        $data = [];
        $data['user'] = $user;
        $data['html'] = view('admin.ajax.home', $data)->render();

        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
    }
}
