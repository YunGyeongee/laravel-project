<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Board;

class MemberController extends Controller
{
    public function index(){
        return view('index');
    }

    public function login(Request $request, Member $member, Board $board){
        $validation = $request->validate([
            'id' => 'required',
            'password' => 'required',
        ]);

        $login_infos = $request->only('id', 'password');
        $members = Member::select('id', 'password')
            ->get();
  
        
        if(Auth::attempt($validation)) { // 로그인 실패
            return redirect()->back();
        } else { // 로그인 성공
             
            $member_id = $member->id;
            $members = Member::select('id', 'name', 'password', 'nickname') 
                ->where([['status', 0], ['id', $member_id]])
                ->get();
            
            // $members = Memer:: . . . ->get();
            // $member = Member:: . . . ->first();
            // $members[0] == $member
            $board_id = $board->id;
            $boards = Board::select('id', 'title', 'content', 'created_at')
                ->where('status', 0)
                ->get();

            var_dump($member); var_dump($board); die;
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
