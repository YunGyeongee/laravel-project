<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board; 
use App\Models\Reply;

class ReplyController extends Controller
{
    public function store(Request $request){
        request()->validate([
            'board_id' => 'required',
            'content' => 'required'
        ]);

        $reply = new Reply;
        $reply->board_id = request('board_id');
        $reply->content = request('content');
        $reply->status = 0;
        $reply->save();

        return redirect()->back();
    }

    public function edit(Request $request, Reply $reply) {
        return view('replies.edit', compact('reply'));
    }

    public function update(Request $request, Board $board, Reply $reply){

        request()->validate([
            'content' => 'required'
        ]);

        $reply->update([
            'content'=>request('content')
        ]);

        return redirect('/boards');

    }

    public function destroy(Request $request, Reply $reply){
        $reply_id = $request->input('id');
        
        $reply = Reply::select('status')
            ->where('id', $reply_id)
            ->first();
        if(!$reply) {
            return '존재하지 않는 댓글 입니다.';
        } else if($reply->status == 1) {
            return '이미 삭제된 댓글 입니다.';
        } else {
            $result = Reply::where('id', $reply_id)->update(['status' => 1]);

            if ($result > 0) {
                return redirect()->back();
            } else {
                return 'error';
            }
        }
    }
}
