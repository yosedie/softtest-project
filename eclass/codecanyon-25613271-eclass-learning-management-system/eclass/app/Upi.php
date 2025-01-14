<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upi extends Model
{
    use HasFactory;
    protected $fillable = [ 'name', 'upiid', 'status'];

}
