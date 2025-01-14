<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
	protected $table = 'coupons';
	
    protected $fillable = [
      'code','distype','amount','link_by','maxusage','minamount','expirydate','course_id', 'category_id',
      'bundle_id','stripe_coupon_id', 'show_to_users'
    ];

    public function cate (){
     	return $this->belongsTo("App\Categories","category_id")->withDefault();
    }

    public function product (){
     	return $this->belongsTo("App\Course","course_id")->withDefault();
    }
}
