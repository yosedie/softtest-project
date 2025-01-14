<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructorskill extends Model
{
    use HasFactory;
    protected $fillable = ['instructor_id', 'skills'];
    public function user()
    {
        return $this->belongsTo('App\User','instructor_id','id')->withDefault();
    } 

}
