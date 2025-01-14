<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class QuizTopic extends Model
{
	use HasTranslations;
    
    public $translatable = ['title', 'description'];

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

	  protected $table = 'quiz_topics';

    protected $fillable = ['course_id', 'title', 'description', 'per_q_mark', 'timer', 'status', 'quiz_again', 'due_days', 'type'];


    public function quizquestion()
    {
        return $this->hasMany('App\Quiz','topic_id');
    }

    public function courses()
    {
      return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }

    
}
