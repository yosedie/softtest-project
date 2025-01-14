<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBankDetail extends Model
{
	protected $table = 'user_bank';

    protected $fillable = ['user_id', 'bank_name', 'ifcs_code', 'account_number', 'account_holder_name' , 'swift_code', 'bank_enable'];

    public function user(){
    	return $this->belongsTo('App\User','user_id','id')->withDefault();
    }
}
