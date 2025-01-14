<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videosetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'url','tittle','description','image'
    ];
}
