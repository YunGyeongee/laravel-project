<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Reply;

class BoardController extends Controller
{
    public function index(){
        // 필요한 쿼리빌더, 컬럼만 요청하여 사용
        $boards = DB::table('boards')->select('title')->where('stauts', '=', 'Y');
        return view('boards.index', compact('boards'));
    }
    
    public function create(){
        return view('boards.create');
    }

    public function store(Request $request){
        // 유효성 검사
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

    public function read(Request $request, Board $board, Reply $reply){
        $boardID = $board->id;
        $reply = DB::table('replies')->where('content', '=', $boardID)->get();
        return view('boards.read', compact('board', 'reply'));
    }

    public function edit(Request $request, Board $board){
        return view('boards.edit', compact('board'));
    }

    public function update(Request $request, Board $board){
        // 유효성 검사
        $validation = Validator::make(request()->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);
        
        // request 이용해 관리할 테이블의 고유 인덱스값을 주고 받아 필요한 쿼리빌더 요청
        $request = $board->id

        if($validation->falis()){
            return redirect()->back();
        } else {
            Board::update([
                'title' => request() -> title,
                'content' => request() -> content
            ]);
            return redirect('/boards/'.$request);
        }
    }

    public function destroy(Request $request, Board $board){
        //$board->delete(); -> 직접적인 데이터 삭제 지양
        $boards = DB::update('update boards set id = ? where status = ?', ['id', 'N']);
        
        return redirect('/boards');
    }
}
