<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model
{
	use HasTranslations;
    
    public $translatable = ['details'];

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

    public $timestamps = false;

    protected $table = 'testimonials';

  	protected $fillable = [
      	'client_name','details','status','image', 'created_at', 'updated_at','rating','designation'
  	];
}
