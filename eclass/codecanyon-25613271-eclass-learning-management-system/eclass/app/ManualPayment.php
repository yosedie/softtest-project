<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManualPayment extends Model
{
    protected $table = 'manual_payment';  

    protected $fillable = [
        'name', 'detail', 'image', 'status'
    ];
}
