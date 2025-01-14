<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransactions extends Model
{
	protected $table = 'wallet_transactions';
	
    protected $fillable = ['user_id', 'wallet_id', 'type', 'total_amount', 'payment_method', 'transaction_id', 'currency', 'currency_icon', 'detail'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
