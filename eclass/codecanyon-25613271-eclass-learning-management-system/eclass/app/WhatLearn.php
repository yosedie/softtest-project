<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class WhatLearn extends Model
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

    protected $table = 'what_learns';

    protected $fillable = [
		'course_id', 'detail', 'status' 
  	]; 

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }
}
