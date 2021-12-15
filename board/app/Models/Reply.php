<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model 
{
    use HasFactory;
    protected $connection = 'mysql'; 
    protected $table = 'REPLY'; 
    public $timestamps = false;

    protected $fillable = ['REPLY_NO', 'REPLY_CONTENT', 'REPLY_CREATED', 'REPLY_UPDATED', 'REPLY_STATUS'];
}