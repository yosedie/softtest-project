<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Assignment extends Model
{
	use HasTranslations;
    
    public $translatable = ['title'];

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
      $attributes = parent::toArray();
      
      foreach ($this->getTranslatableAttributes() as $name) {
          $attributes[$name] = $this->getTranslation($name, app()->getLocale());
      }
      
      return $attributes;
    }

    protected $table = 'assignments';

    protected $fillable = ['user_id', 'instructor_id', 'course_id', 'title', 'assignment', 'type', 'chapter_id', 'detail', 'rating'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }	

    public function chapter()
    {
      return $this->belongsTo('App\CourseChapter','chapter_id','id')->withDefault();
    } 

    public function instructor()
    {
        return $this->belongsTo('App\User','instructor_id','id')->withDefault();
    }
}
