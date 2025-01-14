<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SubCategory extends Model
{
    use HasTranslations;
    
    public $translatable = ['title'];

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

    protected $table = 'sub_categories';   

    protected $fillable = [
        'title','icon','slug','featured','status', 'category_id'
    ]; 

    public function childcategory()
    {
    	return $this->hasMany('App\ChildCategory','subcategory_id');
    }

    public function categories()
    {
    	return $this->belongsTo('App\Categories','category_id','id')->withDefault();
    }

    public function courses()
    {   
        return $this->hasMany('App\Course','subcategory_id');
    }
}
