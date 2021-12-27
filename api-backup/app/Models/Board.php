<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = [
        'id', 
        'member_id', 
        'title', 
        'content', 
        'status',
    ];
}
