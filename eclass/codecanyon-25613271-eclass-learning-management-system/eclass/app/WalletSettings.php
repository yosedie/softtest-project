<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletSettings extends Model
{
	protected $table = 'wallet_settings';
	
    protected $fillable = ['status', 'paytm_enable', 'paypal_enable', 'razorpay_enable', 'stripe_enable', 'ssl_enable', 'paystack_enable', 'braintree_enable'];
}
