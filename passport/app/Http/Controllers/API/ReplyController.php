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
}
