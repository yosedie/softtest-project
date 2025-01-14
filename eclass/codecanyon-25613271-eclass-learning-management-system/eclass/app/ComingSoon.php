<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ComingSoon extends Model
{
	use HasTranslations;
    
    public $translatable = ['heading', 'text_one', 'text_two', 'text_three', 'text_four', 'btn_text'];

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

    protected $table = 'coming_soons';  

    protected $fillable = [ 'bg_image', 'heading', 'count_one', 'count_two', 'count_three', 'count_four', 'text_one', 'text_two', 'text_three', 'text_four', 'btn_text', 'allowed_ip', 'enable' ];

    protected $casts = [
        'allowed_ip' => 'array'
    ];
}
