<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\board;

class BoardManaController extends Controller
{
    /**
     * 관리자 - 게시글 관리
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $boards = board::select('boards.id', 'users.name', 'boards.title', 'boards.status', 'boards.created_at')
            ->join('users', 'users.id', '=', 'boards.user_id')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.boards.main', compact('boards'));

    }

    /**
     * 관리자 - 게시글 상세보기
     * @param board $board
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function read(Board $board)
    {
        $board_id = $board->id;
        $board = board::select('boards.id', 'users.name', 'boards.title', 'boards.content', 'boards.created_at')
            ->where('boards.id', $board_id)
            ->join('users', 'users.id', '=', 'boards.user_id')
            ->first();

        if (!$board) {
            echo '존재하지 않은 회원';
        }

        return view('admin.boards.detail', compact('board'));
    }

    /**
     * 관리자 - 새 글 작성
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.boards.create');
    }
}
