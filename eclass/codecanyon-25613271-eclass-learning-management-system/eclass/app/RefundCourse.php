<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefundCourse extends Model
{
    protected $table = 'refund_courses';

    protected $fillable = [ 'course_id', 'user_id', 'instructor_id', 'order_id', 'refund_transaction_id', 'ref_id', 'txn_fee', 'payment_method', 'total_amount', 'currency', 'currency_icon', 'status', 'reason', 'detail', 'approved', 'bank_id', 'order_refund_id', 'refunded_amt'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }

    public function order()
    {
    	return $this->belongsTo('App\Order','order_id','id')->withDefault();
    }
}
