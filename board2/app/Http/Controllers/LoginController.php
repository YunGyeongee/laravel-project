<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){
        $validation = $request -> only(['name', 'email', 'password']);
        
        if(Auth::attempt($validation)){
            return view('main');
        } else{
            return redirect()->back();
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('main');
    }
}