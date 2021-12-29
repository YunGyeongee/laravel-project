<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    // 메인 페이지
    public function index(Board $board)
    {
        $boards = Board::select('id', 'title', 'content', 'created_at')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        return view('main', compact('boards'));
    }
}
