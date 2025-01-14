<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinInstructor extends Model
{
    use HasFactory;
    protected $fillable = [
        'img', 'detail', 'text'
    ];
}
