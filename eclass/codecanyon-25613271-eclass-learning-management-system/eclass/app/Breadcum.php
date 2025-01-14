<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breadcum extends Model
{
    use HasFactory;
    protected $fillable = [
        'img', 'text'
    ];
}
