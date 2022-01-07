<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client as OClient;
use Symfony\Component\HttpFoundation\Response;

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
     * 글작성 폼
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $user = Auth::user();

        $data = [];
        $data['user'] = $user;
        $data['html'] = view('boards.ajax.create', $data)->render();

        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
    }

    /**
     * 게시글 저장
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function store(Request $request)
    {
        $valid = validator($request->only('title', 'content'),[
            'title' => 'required|string|max:20',
            'content' => 'required|string'
        ]);

        if ($valid->fails()) {
            return response()->json([
                'error' => $valid->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }

        $user = Auth::user();
        $target = $user->id;

        $data = request()->only('title', 'content');

        $board = Board::create([
            'member_id' => $target,
            'title' => $data['title'],
            'content' => $data['content']
        ]);

        return response()->json(['success' => true, 'alert' => '', 'data' => $board], 200);

    }

    /**
     * 게시글 수정폼
     * @param Request $request
     * @param Board $board
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function edit(Request $request, Board $board)
    {
        $user = Auth()->user();

        $board_id = $board->id;
        $board = Board::select('boards.id', 'users.name', 'boards.title', 'boards.content')
            ->where([['boards.id', $board_id],['boards.status', 0]])
            ->join('users', 'users.id', '=', 'boards.member_id')
            ->first();

        if (!$board) {
            echo '존재하지 않는 게시글';
        }

        $user_info = Board::select('users.id')
            ->where([['boards.id', $board_id], ['boards.status', 0]])
            ->join('users', 'users.id', '=', 'boards.member_id')
            ->first();

        if ($user_info->id != $user->id) {
            echo "수정 권한이 없습니다.";
        } else {
            return response()->json(['success' => true, 'alert' => '', 'data' => $board], 200);
        }
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
