<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $table = 'institute';
	
    protected $fillable = [ 'title','user_id','detail','skill','image','status','verified','mobile','email','address','affilated_by','slug'];

}
