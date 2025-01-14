<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
	protected $table = 'currencies';
	
    protected $fillable = [ 'icon', 'currency', 'default', 'name', 'code', 'symbol', 'format', 'exchange_rate', 'active','position'];
}
