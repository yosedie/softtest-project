<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trusted extends Model
{
	protected $table = 'trusteds';
	
    protected $fillable = [
        'url', 'image', 'status',
    ];
}
