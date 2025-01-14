<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compare extends Model
{
    protected $fillable = ['user_id','course_id'];

    public function compares()
    {   
        return $this->hasMany('App\Course','id','course_id');
    }
}
