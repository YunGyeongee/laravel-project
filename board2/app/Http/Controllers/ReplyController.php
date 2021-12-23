<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Board;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function store(Request $request, User $user, Board $board, Reply $reply){
        $validation = $request -> validate([
            'board_id' => 'required',
            'content' => 'required'
        ]);

        $board_id = $request->input('board_id');

        $reply = new Reply();
        $reply->member_id = User::find(Auth::user()->id)->id;
        $reply->board_id = $board_id;
        $reply->content = $validation['content'];
        $reply->status = 0;
        $reply->save();

        return redirect()->back();
    }

    public function edit(Request $request, User $user, Reply $reply) {
        $reply_id = $reply->id;
        $reply = Reply::select('id', 'content')
            ->where([['id', $reply_id], ['status', 0]])
            ->first();
        
        $user_info = Reply::select('users.id')
            ->where([['replies.id', $reply_id], ['replies.status', 0]])
            ->join('users', 'users.id', '=', 'replies.member_id')
            ->first();

        $login_user = Auth::user()->id;

        if ($user_info->id != Auth::user()->id) {
            echo "수정 권한이 없습니다.";
        } else {
            return view('replies.edit', compact('reply'));
        }
    }

    public function update(Request $request, Reply $reply) {
        $reply_id = $request->input('reply_id');
        $reply -> update([
            'content' => request('content')
        ]);

        return redirect()->route('boardMain');
    }

    public function destroy(Request $request, User $user, Reply $reply) {
        $reply_id = $request->input('id');
        $reply = Reply::select('status')
            ->where('id', $reply_id)
            ->first();

        $user_info = Reply::select('users.id')
            ->where([['replies.id', $reply_id], ['replies.status', 0]])
            ->join('users', 'users.id', '=', 'replies.member_id')
            ->first();

        $login_user = Auth::user()->id;

        if ($user_info->id != Auth::user()->id) {
            echo "수정 권한이 없습니다.";
        } else {
            if (!$reply) {
                return '존재하지 않는 댓글 입니다.';
            } else if($reply->status == 1) {
                return '이미 삭제된 댓글 입니다.';
            } else {
                $result = Reply::where('id', $reply_id)->update(['status' => 1]);
    
                if ($result > 0) {
                    return redirect('/boards');
                } else {
                    return '오류가 발생하였습니다.';
                }
            }
        }
    }
}