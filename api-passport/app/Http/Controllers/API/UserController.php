<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    //
    public function currentUserInfo()
    {
        return response()->json([
            'user' => Auth::user()
        ], Response::HTTP_OK);
    }
}
