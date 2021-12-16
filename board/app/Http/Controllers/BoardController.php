<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Board;

class BoardController extends Controller
{
    public function index(){
        $boards = DB::table('boards')->select('title')->where('stauts', '=', 'Y');
        return view('boards.index', compact('boards'));
    }
    
    public function create(){
        return view('boards.create');
    }

    public function store(Request $request){
        $validation = Validator::make(request()->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);
        
        if($validation->falis()){
            return redirect()->back();
        } else {
            Board::create([
                'title' => request() -> title,
                'content' => request() -> content
            ]);
            return redirect('/boards');
        }
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
        $validation = Validator::make(request()->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);
        
        if($validation->falis()){
            return redirect()->back();
        } else {
            Board::update([
                'title' => request() -> title,
                'content' => request() -> content
            ]);
            return redirect('/boards/'.$board->id);
        }
    }

    public function destroy(Board $board){
        //$board->delete(); -> 직접적인 데이터 삭제 지양
        $boards = DB::update('update boards set id = ? where status = ?', ['id', 'N']);
        
        return redirect('/boards');
    }
}
