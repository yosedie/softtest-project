<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facts extends Model
{
    use HasFactory;
    protected $fillable = [
    	'image', 'title', 'description', 'number', 'status'
	  ];
}
