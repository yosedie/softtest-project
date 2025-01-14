<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateCourse extends Model
{
    use HasFactory;

    protected $table = 'private_course';

    protected $fillable = ['user_id', 'course_id', 'status'];

    protected $casts = [
    	'user_id' => 'array'
    ];

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }
}
