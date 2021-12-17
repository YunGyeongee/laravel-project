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

    public function read(Request $request, Board $board, Reply $reply){
        $board_id = $board->id;
        $board = Board::select('title', 'content')
            ->where('id', $board_id)
            ->first();

        // 댓글 조회
        $reply = Reply::select('content')
            ->where('board_id', '=', $board_id)
            ->get();
        return view('boards.read', compact('board', 'reply'));
    }

    public function edit(Request $request, Board $board){
        return view('boards.edit', compact('board'));
    }

    public function update(Request $request, Board $board){

        request()->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $board->update([
            'title'=>request('title'),
            'content'=>request('content')
        ]);

        return redirect('/boards/'.$board->id);
    }

    public function destroy(Request $request, Board $board){
        // -> 직접적인 데이터 삭제 지양
        // $board->delete(); 
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
