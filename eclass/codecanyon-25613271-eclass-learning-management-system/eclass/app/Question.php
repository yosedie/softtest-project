<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Question extends Model
{
    use HasTranslations;
    
    public $translatable = ['question'];

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

    protected $table = 'questions';

    protected $fillable = [
        'course_id', 'user_id', 'instructor_id', 'question', 'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }
    
    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }

    public function instructor()
    {
      return $this->belongsTo('App\User','instructor_id','id')->withDefault();
    }

    public function answers()
    {
        return $this->hasMany('App\Answer','question_id');
    }

    public static function scopeSearch($query, $searchTerm)
    {
        return $query->where('question', 'like', '%' .$searchTerm. '%');
    }
}
