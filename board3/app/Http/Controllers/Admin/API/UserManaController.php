<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserManaController extends Controller
{
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
