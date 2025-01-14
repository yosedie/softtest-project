<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Appointment extends Model
{
	use HasTranslations;
    
    public $translatable = ['title', 'detail'];

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

    protected $fillable = ['user_id', 'instructor_id', 'course_id', 'title', 'detail', 'start_time', 'request', 'accept', 'files', 'status', 'reply'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }	

    public function instructor()
    {
      return $this->belongsTo('App\User','instructor_id','id')->withDefault();
    }
}
