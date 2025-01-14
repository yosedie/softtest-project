<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
	use HasTranslations;
    
    public $translatable = ['heading', 'sub_heading', 'search_text', 'detail'];

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

    protected $table = 'sliders';

    protected $fillable = ['heading', 'sub_heading', 'search_text', 'detail', 'status', 'image', 'position', 'left', 'search_enable'];
}
