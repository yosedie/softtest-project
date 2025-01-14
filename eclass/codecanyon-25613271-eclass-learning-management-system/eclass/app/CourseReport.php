<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseReport extends Model
{
	protected $table = 'course_reports';
	
    protected $fillable = ['user_id', 'course_id', 'title', 'email', 'detail'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }
}
