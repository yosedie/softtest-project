<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FaqStudent extends Model
{
	use HasTranslations;

    public $translatable = ['title', 'details'];

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

    protected $table = 'faq_students';

  	protected $fillable = [
      	'category_id', 'title', 'details', 'status', 
  	];
}
