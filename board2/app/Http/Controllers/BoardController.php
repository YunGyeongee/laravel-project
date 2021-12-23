<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function index(Board $board){
        $board_id = $board->id;
        $boards = Board::select('id', 'title', 'content', 'created_at')
            ->where('status', 0)
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

    public function read(Request $reqeust, Board $board){
        $board_id = $board->id;
        $board = Board::select('boards.id', 'users.name', 'boards.title', 'boards.content')
            ->where([['boards.id', $board_id],['boards.status', 0]])
            ->join('users', 'users.id', '=', 'boards.member_id')
            ->first();

        return view('boards.read', compact('board'));
    }

    public function edit(Request $reqeust, Board $board){
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

}