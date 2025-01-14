<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ChildCategory extends Model
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

    protected $table = 'child_categories';   

    protected $fillable = [
		  'category_id', 'subcategory_id','title','status', 'slug', 'icon'
    ]; 

    public function subcategory()
    {
    	return $this->belongsTo('App\SubCategory','subcategory_id','id')->withDefault();
    }
    public function categories()
    {
    	return $this->belongsTo('App\Categories','category_id','id')->withDefault();
    }

 	  public function courses()
    {   
        return $this->hasMany('App\Course','childcategory_id');
    }
}
