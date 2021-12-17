<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Reply;

class BoardController extends Controller
{
    public function index(){
        $boards = DB::select('select id, title from boards where status=0');
        return view('boards.index', compact('boards'));
    }
    
    public function create(){
        return view('boards.create');
    }

    public function store(Request $request){

        request()->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $board = new Board();
        $board->title = request('title');
        $board->content = request('content');
        $board->save();

        return redirect('/boards');
    }

    public function read(Board $board){
        $boardID = $board->id;
        $reply = DB::table('replies')->where('ReplyContent', '=', $boardID)->get();
        return view('boards.read', compact('board', 'reply'));
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
        // -> 직접적인 데이터 삭제 지양
        $board->delete(); 
        
        // $boardID = $board->id
        // $board = DB::update('update boards set status = 1 where = ?', $boardID);

        return redirect('/boards');
    }
}
