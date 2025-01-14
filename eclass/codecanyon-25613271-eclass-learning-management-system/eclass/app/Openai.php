<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Openai extends Model
{
    use HasFactory;
    protected $fillable = [
    	'generate', 'user_id', 'prompt', 'response'
    ];
}
