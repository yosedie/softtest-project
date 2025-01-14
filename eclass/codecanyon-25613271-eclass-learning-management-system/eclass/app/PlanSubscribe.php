<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSubscribe extends Model
{
    use HasFactory;

    protected $table = 'plan_subscription';

    protected $fillable = [
        'plan_id',
        'user_id',
        'order_id',
        'transaction_id',
        'payment_method',
        'total_amount',
        'currency',
        'currency_icon',
        'duration',
        'duration_type',
        'enroll_start',
        'enroll_expire'

    ];

    public function plans()
    {
        return $this->belongsTo('App\InstructorPlan','plan_id','id')->withDefault();
    } 

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }   
}
