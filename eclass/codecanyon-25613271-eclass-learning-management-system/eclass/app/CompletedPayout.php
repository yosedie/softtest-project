<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompletedPayout extends Model
{
	protected $table = 'completed_payouts'; 

	protected $fillable = ['user_id', 'payer_id', 'pay_total', 'order_id', 'payment_method', 'currency', 'currency_icon', 'pay_status' ];

    protected $casts = [
    	'order_id' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id','id')->withDefault();
    }

    public function payer()
    {
        return $this->belongsTo('App\User', 'payer_id','id')->withDefault();
    }

    public function order(){
        return $this->belongsTo('App\Order','order_id','id')->withDefault();
    }
    
    
}
