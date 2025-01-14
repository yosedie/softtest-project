<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coursereject extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'reason']; 

}
