<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousPaper extends Model
{
    use HasFactory;

    protected $table = 'previous_paper';

    protected $fillable = ['course_id', 'title', 'file', 'detail', 'status'];

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }	
}
