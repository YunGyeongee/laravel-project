<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{

    public function index()
    {
        return view('register');
    }

    public function store(Request $request){
        $validation = $request -> validate([
            'name' => 'required',
            'email' => 'required|unique:users|string',
            'password' => 'required',
            'nickname' => 'required',
        ]);

        User::create([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'password' => Hash::make($validation['password']),
            'nickname' => $validation['nickname']
        ]);

        return redirect('/');

    }

}