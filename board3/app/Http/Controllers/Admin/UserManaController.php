<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserManaController extends Controller
{
    /**
     * 관리자 - 회원 관리
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::select('id', 'name', 'nickname', 'status', 'created_at', 'updated_at')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.users.main', compact('users'));
    }

    /**
     * 관리자 - 회원 상세 페이지
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function read(User $user)
    {
        $user_id = $user->id;
        $user = User::select('id', 'name', 'nickname', 'password', 'status', 'created_at', 'updated_at')
            ->where('id', $user_id)
            ->orderBy('id', 'desc')
            ->first();

        if (!$user) {
            echo '존재하지 않은 회원';
        }

        return view('admin.users.detail', compact('user'));
    }
}
