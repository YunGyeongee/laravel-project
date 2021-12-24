<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Board;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request, Board $board){
        $validation = $request -> only(['email', 'password']);

        $board_id = $board->id;
        $boards = Board::select('id', 'title', 'content', 'created_at')
            ->where('status', 0)
            ->orderBy('id', 'desc')
            ->get();

        if(Auth::attempt($validation)){
            return view('main', compact('boards'));
        } else{
            return redirect()->back();
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('main');
    }

    public function myIndex(){
        return view('users.myPage');
    }

    public function myUpdate(Request $request){
        $validation = $request -> validate([
            'nickname' => 'required'
        ]);
        
        $user = User::find(Auth::user()->id);
        $user -> nickname = $validation['nickname'];
        $user -> save();

        return redirect()->back();

    }

}