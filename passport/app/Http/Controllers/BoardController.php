<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    /**
     * 메인 페이지
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $boards = Board::select('id', 'title', 'content', 'created_at')
            ->where('status', 0)
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
     * 게시글 상세보기
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function read(Request $request)
    {
        $board_id = $request->input('board_id');
        $board = Board::select('boards.id', 'users.name', 'boards.title', 'boards.content')
            ->where('boards.id', $board_id)
            ->join('users', 'users.id', '=', 'boards.member_id')
            ->first();

        return view('board.read', compact('board'));
    }

    /**
     * 게시글 수정폼
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(Request $request)
    {

        // 유효성 검사 추가하기 - 01/07
        $board_id = $request->input('board_id');
        $board = Board::select('boards.id', 'users.name', 'boards.title', 'boards.content')
            ->where([['boards.id', $board_id],['boards.status', 0]])
            ->join('users', 'users.id', '=', 'boards.member_id')
            ->first();

        if (!$board) {
            echo '존재하지 않는 게시글';
        }

        $user_info = Board::select('users.id')
            ->where([['boards.id', $board_id], ['boards.status', 0]])
            ->join('users', 'users.id', '=', 'boards.member_id')
            ->first();

        if ($user_info->id != Auth::user()->id) {
            echo "수정 권한이 없습니다.";
        } else {
            return view('boards.edit', compact('board'));
        }
    }
}
