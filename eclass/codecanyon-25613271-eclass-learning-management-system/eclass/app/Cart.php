<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	protected $table = 'carts';

    protected $fillable = ['user_id', 'course_id', 'category_id', 'price', 'offer_price', 'disamount', 'distype', 'bundle_id', 'type' ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }

    public function bundle()
    {
        return $this->belongsTo('App\BundleCourse','bundle_id','id')->withDefault();
    }
}
