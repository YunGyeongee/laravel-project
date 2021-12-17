<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
