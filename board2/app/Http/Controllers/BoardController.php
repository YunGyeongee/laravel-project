<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Board;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function index(Board $board){
        $board_id = $board->id;
        $boards = Board::select('id', 'title', 'content', 'created_at')
            ->where('status', 0)
            ->orderBy('id', 'desc')
            ->get();

        return view('main', compact('boards'));
    }

    public function create(){
        return view('boards.create');
    }

    public function store(Request $request, Board $board, User $user){
        $validation = $request -> validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $board = new Board();
        $board -> member_id = User::find(Auth::user()->id)->id;
        $board -> title = $validation['title'];
        $board -> content = $validation['content'];
        $board -> save();

        return redirect()->route('boardMain');
    }

    public function read(Request $request, User $user, Board $board, Reply $reply){
        $board_id = $board->id;
        $board = Board::select('boards.id', 'users.name', 'boards.title', 'boards.content')
            ->where([['boards.id', $board_id],['boards.status', 0]])
            ->join('users', 'users.id', '=', 'boards.member_id')
            ->first();
        
        // 댓글 조회
        $replies = Reply::select('users.name', 'replies.content', 'replies.created_at')
                ->where([['board_id', $board_id], ['replies.status', 0]])
                ->join('users', 'users.id', '=', 'replies.member_id')
                ->get();

        return view('boards.read', compact('board', 'replies'));
    }

    public function edit(Request $request, Board $board){
        $board_id = $board->id;
        $board = Board::select('boards.id', 'users.name', 'boards.title', 'boards.content')
            ->where([['boards.id', $board_id],['boards.status', 0]])
            ->join('users', 'users.id', '=', 'boards.member_id')
            ->first();
        return view('boards.edit', compact('board'));
    }

    public function update(Request $request, Board $board){
        $board -> update([
            'title' => request('title'),
            'content' => request('content')
        ]);

        return redirect('/boards/'.$board->id);
    }

    public function destroy(Request $request, Board $board){
        $board_id = $request->input('board_id');
        $board = Board::select('status')
            ->where('id', $board_id)
            ->first();
        
        if (!$board) {
            return '존재하지 않는 게시글 입니다.';
        } else if($board->status == 1) {
            return '이미 삭제된 게시글 입니다.';
        } else {
            $result = Board::where('id', $board_id)->update(['status' => 1]);

            if ($result > 0) {
                return redirect('/boards');
            } else {
                return '오류가 발생하였습니다.';
            }
        }
    }
}