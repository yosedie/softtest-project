<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Blog extends Model
{
	use HasTranslations;
    
    public $translatable = ['heading', 'detail', 'text'];

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

	  protected $table = 'blogs';

    protected $fillable = ['user_id', 'date', 'image', 'heading', 'detail', 'text', 'approved', 'status', 'slug'];
     
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }
}
