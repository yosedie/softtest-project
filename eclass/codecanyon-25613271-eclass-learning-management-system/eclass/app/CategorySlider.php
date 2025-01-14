<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategorySlider extends Model
{
	protected $table = 'category_sliders'; 
	
    protected $fillable = ['category_id', 'category_to_show'];

    protected $casts = [
    	'category_id' => 'array'
    ];

    public function categories()
    {
    	return $this->belongsTo('App\Categories','category_id','id')->withDefault();
    }
}
