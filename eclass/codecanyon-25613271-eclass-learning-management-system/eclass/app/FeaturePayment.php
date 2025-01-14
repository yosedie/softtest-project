<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeaturePayment extends Model
{
    protected $table = 'feature_payments';

    protected $fillable = [ 'user_id', 'course_id', 'transaction_id', 'payment_method', 'total_amount', 'currency', 'currency_icon', 'featured'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }

    
}
