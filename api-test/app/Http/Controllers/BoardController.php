<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{

    public function index(Board $board)
    {
        $board_id = $board->id;
        $boards = Board::select('id', 'title', 'content', 'created_at')
            ->where('status', 0)
            ->orderBy('id', 'desc')
            ->get();

        var_dump(auth()->check());
        
        // if(Auth::check()) {
            return view('main', compact('boards'));
        // } else {
        //     return redirect()->back();
        // }
        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Board $board)
    {
        //
    }

    public function edit(Board $board)
    {
        //
    }

    public function update(UpdateBoardRequest $request, Board $board)
    {
        //
    }

    public function destroy(Board $board)
    {
        //
    }
}
