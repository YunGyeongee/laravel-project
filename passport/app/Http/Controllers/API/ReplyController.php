<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{
    /**
     * 댓글 작성
     * @param Request $request
     * @param Board $board
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Board $board)
    {
        $valid = validator($request->only('content'),[
            'content' => 'required|string|max:50',
        ]);

        if ($valid->fails()) {
            return response()->json([
                'error' => $valid->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }

        $user = Auth::user();
        $user_id = $user->id;
        $board_id = $board->id;

        $data = request()->only('content');

        $reply = Reply::create([
            'board_id' => $board_id,
            'member_id' => $user_id,
            'content' => $data['content'],
        ]);

        return response()->json(['success' => true, 'alert' => '', 'data' => $reply], 200);
    }

    /**
     * 댓글 수정폼
     * @param Reply $reply
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function edit(Reply $reply)
    {
        $user = Auth::user();

        $reply_id = $reply->id;
        $reply = Reply::select('replies.id', 'boards.id', 'users.name', 'replies.content')
            ->where([['replies.id', $reply_id], ['replies.status', 0]])
            ->join('users', 'users.id', '=', 'replies.member_id')
            ->join('boards', 'boards.id', '=', 'replies.board_id')
            ->first();

        if (!$reply) {
            echo '존재하지 않는 댓글';
        }

        $user_info = Reply::select('users.id')
            ->where([['replies.id', $reply_id], ['replies.status', 0]])
            ->join(['users', 'users.id', '=', 'replies.member_id'])
            ->first();

        if ($user_info->id != $user->id) {
            echo '수정 권한이 없습니다.';
        } else {
            $data = [];
            $data['user'] = $user;
            $data['reply'] = $reply;
            $data['html'] = view('replies.ajax.edit', $data)->render();

            return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
        }
    }

    public function destroy(Reply $reply)
    {
        $reply_id = $reply->id;
        $reply = Reply::select('status')
            ->where('id', $reply_id)
            ->first();

        $user_info = Reply::select('users.id')
            ->where([['replies.id', $reply_id], ['replies.status', 0]])
            ->join(['users', 'users.id', '=', 'replies.member_id'])
            ->first();

        $user = Auth::user();
        $target = $user->id;

        if ($user_info->id != $target) {
            echo '수정 권한이 없습니다.';
        } else {
            if (!$reply) {
                return '존재하지 않는 게시글 입니다.';
            } else if ($reply->status == 1) {
                return '이미 삭제된 게시글 입니다.';
            } else {
                $result = Board::where('id', $reply_id)->update(['status' => 1]);

                if ($result > 0) {
                    $data = [];
                    $data['user'] = $user;
                    $data['reply'] = $reply;

                    return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
                } else {
                    return '오류가 발생하였습니다.';
                }
            }
        }
    }
}
