<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatedCourse extends Model
{
	protected $table = 'related_courses';  
	
    protected $fillable = [ 'user_id', 'course_id', 'main_course_id', 'status' ];

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }

    public function user()
    {
    	return $this->belongsTo('App\User','user_id', 'id')->withDefault();
    }
}
