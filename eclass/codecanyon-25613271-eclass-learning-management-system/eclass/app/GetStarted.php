<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class GetStarted extends Model
{
	use HasTranslations;

    public $translatable = ['heading', 'sub_heading', 'button_txt'];

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

    protected $table = 'get_starteds';

    protected $fillable = [ 'heading', 'sub_heading', 'button_txt', 'image', 'link' ];
}
