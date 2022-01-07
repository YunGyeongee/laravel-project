<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    /**
     * 메인 페이지
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $boards = Board::select('id', 'title', 'content', 'created_at')
            ->where('status', 0)
            ->orderBy('id', 'desc')
            ->get();

        return view('main', compact('boards'));
    }

    /**
     * 게시글 저장
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function store(Request $request)
    {

        $user = Auth::user();
        $target = $user->id;

        $validation = $request->validate([
           'title' => 'required',
           'content' => 'required'
        ]);

        if( !Auth::attempt($target)) {
            return '로그인 후 이용가능합니다.';
        }

        $data = request()->only('title', 'content');

        $response = post('http://192.168.2.10:8000/oauth/token', [
            'form_params' => [
                'title' => $data['title'],
                'content' => $data['content'],
                'scope' => '',
            ]
        ]);

        $board = new Board();
        $board -> member_id = $target;
        $board -> title = $validation['title'];
        $board -> content = $validation['content'];
        $board -> save();

        $dataResponse = json_decode((string) $response->getBody(), true);

        return response()->json(['success' => true, 'alert' => '', 'data' => $dataResponse], 200);
    }

    // 게시글 수정 저장
    public function update(Request $request, Board $board)
    {
        $board_id = $request->input('board_id');
        $board->update([
            'title' => request('title'),
            'content' => request('content')
        ]);

        return redirect('/boards/'.$board_id);
    }

    // 게시글 삭제하기
    public function destroy(Request $request)
    {
        $board_id = $request->input('board_id');
        $board = Board::select('status')
            ->where('id', $board_id)
            ->first();

        $user_info = Board::select('users.id')
            ->where([['boards.id', $board_id], ['boards.status', 0]])
            ->join('users', 'users.id', '=', 'boards.member_id')
            ->first();

        if ($user_info->id != Auth::user()->id) {
            echo "수정 권한이 없습니다.";
        } else {
            if (!$board) {
                return '존재하지 않는 게시글 입니다.';
            } else if ($board->status == 1) {
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
}
