<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'id', 
        'board_id',
        'member_id', 
        'content', 
        'status',
    ];
}
