<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Reply;
use App\Models\Replies;

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

    public function read(Request $request){
        $board = Board::find($reqeust->id);
        $reply->fill($request)->save();
        //필요한 컬럼과 , where 조건문은 수정이 필요합니다.
        $reply = Replies::select('id', 'content')
            ->where([['board_id', $board->id], ['status', 0]])
            ->orderBy('id', 'ASC')
            ->get()
        // $reply = DB::table('replies')->where('content', '=', $boardID)->get();
        return view('boards.read', ['reqeust' => $request]);
    }

    public function edit(Request $request){
        $board = Board::find($request->id);
        return view('boards.edit', ['board' => $board]);
    }

    public function update(Request $request){
        // request 이용해 관리할 테이블의 고유 인덱스값을 주고 받아 필요한 쿼리빌더 요청
        $request = $board->id
        
        // 유효성 검사
        $validation = Validator::make(request()->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);

        // // Reply 모델 참조해서 update
        // Reply::update($validation);

        if($validation->falis()){
            return redirect()->back();
        } else {
            Board::update([
                'title' => request() -> title,
                'content' => request() -> content
            ]);

            $request->fill($validation)->save();

            return redirect('/boards/'.$request);
        }
    }

    public function destroy(Request $request){
        //$board->delete(); -> 직접적인 데이터 삭제 지양
        $request = $board->id
        $delete = DB::table('boards')
                    ->where('id', $request)
                    ->update(['status' => 'N']);

        return redirect('/boards');
    }
}
