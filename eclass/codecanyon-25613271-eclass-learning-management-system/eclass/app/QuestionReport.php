<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionReport extends Model
{
    protected $table = 'question_reports';
	
    protected $fillable = ['user_id', 'course_id', 'question_id', 'title', 'email', 'detail'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }

    public function question()
    {
    	return $this->belongsTo('App\Question','course_id','id')->withDefault();
    }
}
