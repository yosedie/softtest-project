<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingPayout extends Model
{
    protected $table = 'pending_payouts';

    protected $fillable = [ 'user_id', 'course_id', 'order_id', 'transaction_id', 'total_amount', 'instructor_revenue', 'currency', 'currency_icon' ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id','id')->withDefault();
    }
    
    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }

    public function order(){
        return $this->belongsTo('App\Order','order_id','id')->withDefault();
    }
}
