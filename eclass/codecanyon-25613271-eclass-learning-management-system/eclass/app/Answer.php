<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Answer extends Model
{
    use HasTranslations;
    
    public $translatable = ['answer'];

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

    protected $table = 'answers';
    
    protected $fillable = ['instructor_id', 'ans_user_id', 'ques_user_id', 'course_id', 'question_id', 'answer', 'status',];

    public function user()
    {
      return $this->belongsTo('App\User', 'ans_user_id','id')->withDefault();
    }
    
    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }

    public function question()
    {
    	return $this->belongsTo('App\Question','question_id','id')->withDefault();
    }

    public function instructor()
    {
      return $this->belongsTo('App\User', 'instructor_id','id')->withDefault();
    }
}
