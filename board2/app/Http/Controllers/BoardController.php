<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Board;


class BoardController extends Controller
{
    public function create(){
        return view('boards.create');
    }

    public function store(Request $request, Board $board){
        request()->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $board = new Board();
        $board->title = request('title');
        $board->content = request('content');
        $board->save();

        return redirect('/main');
    }

    public function read(Request $request, Board $board){
        $board_id = $board->id;
        $board = Board::select('title', 'content')
            ->where('id', $board_id)
            ->first();
        
        return view('boards.read', compact('board'));
    }

}
