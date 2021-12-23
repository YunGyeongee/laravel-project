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

    public function edit(Request $request, Reply $reply) {
        $reply_id = $reply->id;
        $reply = Reply::select('id', 'content')
                ->where([['id', $reply_id], ['status', 0]])
                ->first();

        return view('replies.edit', compact('reply'));
    }

    public function update(Request $request, Reply $reply) {
        $reply_id = $request->input('reply_id');
        $reply -> update([
            'content' => request('content')
        ]);

        return redirect()->route('boardMain');
    }

}