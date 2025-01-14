<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstructorSetting extends Model
{
	protected $table = 'instructor_settings';
	
    protected $fillable = ['instructor_enable', 'instructor_revenue', 'admin_revenue', 'paypal_enable', 'paytm_enable', 'bank_enable' ];
}
