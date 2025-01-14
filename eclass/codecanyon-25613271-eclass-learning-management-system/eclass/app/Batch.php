<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Batch extends Model
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

    protected $table = 'batch';

    protected $fillable = ['user_id', 'title', 'detail', 'price', 'type', 'slug', 'status', 'featured', 'preview_image', 'allowed_users', 'allowed_courses', 'allowed_bundles'];

    protected $casts = [
    	'allowed_users' => 'array',
    	'allowed_courses' => 'array',
    	'allowed_bundles' => 'array'
    ];

    public function User()
    {
    	return $this->belongsTo('App\User','allowed_users','id')->withDefault();
    }

    public function courses()
    {
        return $this->belongsTo('App\Course', 'allowed_courses', 'id')->withDefault();
    }
    
}
