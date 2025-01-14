<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CourseLanguage extends Model
{
	use HasTranslations;

    public $translatable = ['name'];

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

    protected $table = 'course_languages';

    protected $fillable = ['name', 'status']; 

    public function courses()
    {   
        return $this->hasMany('App\Course','language_id');
    }
}
