<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankTransfer extends Model
{
	protected $table = 'bank_transfers';

    protected $fillable = ['bank_name', 'ifcs_code', 'account_number', 'account_holder_name' , 'swift_code', 'bank_enable'];
}
