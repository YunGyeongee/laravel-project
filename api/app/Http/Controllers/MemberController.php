<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Http\Resources\Member as MemberResource;

class MemberController extends controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validation = $request -> only(['email', 'password']);

        if(Auth::attempt($validation)){
            return view('main');
        } else{
            return redirect()->back();
        }
    }

    public function logout(){
        Auth::logout();
        return view('/');
    }

    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validation = $request -> validate([
            'name' => 'required',
            'email' => 'required|unique:members',
            'password' => 'required',
            'nickname' => 'required',
        ]);

        $member = new Member();
        $member->name = $request->name;
        $member->email = $request->email;
        $member->password = $request->password;
        $member->nickname = $reqeust->nickname;

        $member->save();

        return Response::json($member);
    }

    public function show(Member $member)
    {
        // return response()->json([
        //     'member' => $member
        // ], 200);
        return new MemberResource($member);
    }
}