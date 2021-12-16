<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;

class ReplyController extends Controller
{
    public function store(){
        $validator = Validator::make(request()->all(), [
            'board_id' => 'required',
            'ReplyContent' => 'required|max:255'
        ]);

        if($validator->fails()){
            return redirect()->back();
        } else{
            Reply::create([
                'board_id' => request() -> board_id,
                'ReplyContent' => request() -> ReplyContent
            ]);
            return redirect()->back();
        }
    }
}
