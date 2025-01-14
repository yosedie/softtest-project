<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Involvement extends Model
{
    protected $table = 'involvements';
    
    protected $fillable = ['course_id','user_id','reason','status'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    } 
     public function course()
    {
        return $this->belongsTo('App\Course','course_id','id')->withDefault();
    } 

}
