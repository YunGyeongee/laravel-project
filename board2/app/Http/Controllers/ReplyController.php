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
}