<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportReview extends Model
{
	protected $table = 'report_reviews';
	
    protected $fillable = ['user_id', 'course_id', 'title', 'email', 'detail', 'review_id '];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }
}
