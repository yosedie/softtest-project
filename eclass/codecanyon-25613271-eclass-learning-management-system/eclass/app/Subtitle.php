<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtitle extends Model
{
	protected $table = 'subtitles';
	
    protected $fillable = ['sub_lang', ' sub_t', 'c_id'];

    public function courseclass()
    {
    	return $this->belongsTo('App\CourseClass','c_id','id')->withDefault();
    }
    
}
