<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
            $members = DB::select('select id, name, password, nickname from members where status=0');
            return view('main', compact('members'));
        }
    }

    public function logout(){
        Auth::logout();
        return view('index');
    }

    public function myPage(Request $reqeust, Member $member){
        $member_id = $member->id;
        $member = Member::select('id', 'name', 'password', 'nickname')
            ->where('id', $member_id)
            ->first();

        return view('member.myPage', compact('member'));
    }

    public function main(){
        $members = DB::select('select id, name, password, nickname from members where status=0');
        return view('main', compact('members'));
    }

    public function nickUp(Reqeust $reqeust, Member $member){
        $validation = $request -> validate([
            'id' => 'required',
            'name' => 'required',
            'password' => 'required',
            'nickname' => 'required',
        ]);

        Member::create([
            'id' => $validation['id'],
            'name' => $validation['name'],
            'password' => $validation['password'],
            'nickname' => $validation['nickname']
        ]);

        return redirect()->back();
    }
}
