<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Reply;
use App\Models\User;

class BoardController extends Controller
{
    /**
     * 메인 페이지
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $boards = Board::select('id', 'title', 'content', 'created_at')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        return view('main', compact('boards'));
    }

    /**
     * 게시글 작성폼
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('boards.create');
    }

    /**
     * 게시물 상세보기
     * @param Board $board
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function read(User $user, Board $board)
    {
        $board_id = $board->id;
        $board = Board::select('boards.id', 'users.name', 'boards.title', 'boards.content')
            ->where([['boards.id', $board_id],['boards.status', 1]])
            ->join('users', 'users.id', '=', 'boards.user_id')
            ->first();

        if (!$board) {
            echo '존재하지 않는 게시글';
        }

        $replies = Reply::select('replies.id', 'users.name', 'replies.content', 'replies.created_at')
            ->where([['board_id', $board_id], ['replies.status', 1]])
            ->join('users', 'users.id', '=', 'replies.user_id')
            ->orderBy('replies.id', 'desc')
            ->get();

        return view('boards.read', compact('user','board', 'replies'));
    }

    /**
     * 게시글 수정폼
     * @param Board $board
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Board $board)
    {
        $board_id = $board->id;
        $board = Board::select('boards.id', 'users.name', 'boards.title', 'boards.content')
            ->where([['boards.id', $board_id],['boards.status', 1]])
            ->join('users', 'users.id', '=', 'boards.user_id')
            ->first();

        if (!$board) {
            echo '존재하지 않는 게시글';
        }

        return view('boards.edit', compact('board'));
    }


}
