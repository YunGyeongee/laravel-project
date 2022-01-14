<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Reply;
use function view;

class ReplyController extends Controller
{
    /**
     * 댓글 수정폼
     * @param Reply $reply
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Reply $reply)
    {
        $reply_id = $reply->id;
        $reply = Reply::select('replies.id', 'replies.board_id', 'users.name', 'replies.content')
            ->where([['replies.id', $reply_id], ['replies.status', 1]])
            ->join('users', 'users.id', '=', 'replies.user_id')
            ->first();

        if (!$reply) {
            echo '존재하지 않는 댓글';
        }

        return view('replies.edit', compact('reply'));
    }
}
