<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Models\board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BoardManaController extends Controller
{
    /**
     * 관리자 - 새 글 작성폼
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $user = Auth::user();

        $data = [];
        $data['user'] = $user;
        $data['html'] = view('admin.boards.ajax.create', $data)->render();

        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
    }

    /**
     * 관리자 - 게시글 작성
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $valid = validator($request->only('title', 'content'),[
            'title' => 'required|string|max:20',
            'content' => 'required|string'
        ]);

        if ($valid->fails()) {
            return response()->json([
                'error' => $valid->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }

        $user = Auth::user();
        $login_user = $user->id;

        $data = request()->only('title', 'content');

        $board = Board::create([
            'user_id' => $login_user,
            'title' => $data['title'],
            'content' => $data['content'],
        ]);

        return response()->json(['success' => true, 'alert' => '', 'data' => $board], 200);
    }

    /**
     * 관리자 - 게시글 수정폼
     * @param board $board
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Board $board)
    {
        $board_id = $board->id;
        $board = board::select('boards.id', 'users.name', 'boards.title', 'boards.content', 'boards.created_at')
            ->where('boards.id', $board_id)
            ->join('users', 'users.id', '=', 'boards.user_id')
            ->first();

        if (!$board) {
            return response()->json(['success' => false, 'alert' => '존재하지 않는 게시글', 'data' => $board], 200);
        } else if ($board->status == 0) {
            return response()->json(['success' => false, 'alert' => '이미 삭제된 게시글 입니다.', 'data' => $board], 200);
        } else {
            $data = [];
            $data['board'] = $board;
            $data['html'] = view('admin.boards.ajax.edit', $data)->render();

            return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
        }
    }

    /**
     * 관리자 - 게시글 수정 저장
     * @param Request $request
     * @param board $board
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, board $board)
    {
        $valid = validator($request->only('title', 'content'),[
            'title' => 'required',
            'content' => 'required'
        ]);

        if ($valid->fails()) {
            return response()->json([
                'error' => $valid->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }

        $board_id = $board->id;
        $board = Board::select('boards.id', 'users.name', 'boards.title', 'boards.content')
            ->where('boards.id', $board_id)
            ->join('users', 'users.id', '=', 'boards.user_id')
            ->first();

        $title = request('title');
        $content = request('content');

        if (!$board) {
            return response()->json(['success' => false, 'alert' => '존재하지 않는 게시글', 'data' => $board], 200);
        } else if ($board->status == 0) {
            return response()->json(['success' => false, 'alert' => '이미 삭제된 게시글 입니다.', 'data' => $board], 200);
        } else {
            $board = DB::table('boards')
                ->where('id', $board_id)
                ->update(['title' => $title, 'content' => $content]);

            $data = [];
            $data['board'] = $board;

            return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
        }
    }

    /**
     * 관리자 - 게시글 삭제
     * @param board $board
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function destroy(Board $board)
    {
        $board_id = $board->id;
        $board = Board::select('status')
            ->where('id', $board_id)
            ->first();

        if (!$board) {
            return '존재하지 않는 게시글 입니다.';
        } else if ($board->status == 0) {
            return '이미 삭제된 게시글 입니다.';
        } else {
            $result = Board::where('id', $board_id)->update(['status' => 0]);

            if ($result == 0) {
                $data = [];
                $data['board'] = $board;

                return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
            } else {
                return '오류가 발생하였습니다.';
            }
        }
    }
}
