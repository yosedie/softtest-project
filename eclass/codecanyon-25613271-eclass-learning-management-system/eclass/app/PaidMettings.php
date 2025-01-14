<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaidMettings extends Model
{
    use HasFactory;

    protected $table = 'paid_mettings';
    protected $fillable = [
        'transaction_id',
        'meeting_id',
        'user_id',
        'course_id',
        'amount',
        'currency',
        'currency_symbol',
        'payment_method',
        'status',
        'type',
        // other existing fields
    ];

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }
}
