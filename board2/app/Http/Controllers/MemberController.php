<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;

class MemberController extends Controller
{
    public function index(){
        return view('index');
    }

    public function login(Request $request){
        $validation = $request->validate([
            'id' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt($validation)) { // 로그인 실패
            return redirect()->back();
        } else { // 로그인 성공
            return view('main');
        }
    }

    public function logout(){
        Auth::logout();
        return view('index');
    }

    public function myPage(){
        return view('member.myPage');
    }

    public function main(){
        return view('main');
    }
}
