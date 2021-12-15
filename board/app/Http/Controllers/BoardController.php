<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Reply;

class BoardController extends Controller
{
    public function index(){
        $boards = Board::all();
        return view('boards.index', compact('boards'));
    }
    
    public function create(){
        return view('boards.create');
    }

    public function store(Request $request){
        $board = Board::create([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);
        return redirect('/boards');
    }

    public function read(Board $board){
        return view('boards.read', compact('board'));
    }

    public function edit(Board $board){
        return view('boards.edit', compact('board'));
    }

    public function update(Board $board){
        $board->update([
            'title'=>request('title'),
            'content'=>request('content')
        ]);
        return redirect('/boards/'.$board->id);
    }

    public function destroy(Board $board){
        $board->delete();
        return redirect('/boards');
    }
}
