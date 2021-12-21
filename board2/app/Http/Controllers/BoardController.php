<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class BoardController extends Controller
{
    public function create(){
        return view('boards.create');
    }

    public function store(Reqeust $request){
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
}
