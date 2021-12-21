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
            $boards = DB::select('select id, title, content, created_at from boards where status=0');
            return view('main', compact('members', 'boards'));
        }
    }

    public function logout(){
        Auth::logout();
        return view('index');
    }

    public function myPage(Request $request, Member $member){
        $member_id = $member->id;
        $member = Member::select('id', 'name', 'password', 'nickname')
            ->where('id', $member_id)
            ->first();

        return view('members.myPage', compact('member'));
    }

    public function main(){
        $members = DB::select('select id, name, password, nickname from members where status=0');
        $boards = DB::select('select id, title, content, created_at from boards where status=0');
        return view('main', compact('members', 'boards'));
    }

    public function nickUp(Request $request, Member $member){
        request() -> validate([
            'nickname' => 'required',
        ]);

        $member->update([
            'nickname' => request('nickname'),
        ]);

        return redirect('/main');
    }
}
