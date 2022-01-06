<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    // 메인 페이지
    public function index()
    {

        $boards = Board::select('id', 'title', 'content', 'created_at')
            ->where('status', 0)
            ->orderBy('id', 'desc')
            ->get();

        return view('main', compact('boards'));
    }

    public function create()
    {
        return view('boards.create');
    }

    public function store(Request $request)
    {

        $user = Auth::user();
//        var_dump($user); die;
        $target = $user->id;

        $validation = $request -> validate([
           'title' => 'required',
           'content' => 'required'
        ]);

        $board = new Board();
        $board -> member_id = $target;
        $board -> title = $validation['title'];
        $board -> content = $validation['content'];
        $board -> save();

        return redirect()->route('main');

    }
}
