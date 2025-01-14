<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeatureCourse extends Model
{
    protected $table = 'feature_courses';

    protected $fillable = [ 'user_id', 'course_id', 'total_amount'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }
}
