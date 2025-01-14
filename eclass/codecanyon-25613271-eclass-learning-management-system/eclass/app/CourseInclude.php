<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CourseInclude extends Model
{
	use HasTranslations;

    public $translatable = ['detail'];

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

    protected $table = 'course_includes';

    protected $fillable = [
        'course_id', 'detail', 'status','icon'
    ];

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }
}
