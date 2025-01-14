<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Downloadqr extends Model
{
    use HasFactory;
    protected $fillable = [ 'image', 'image2' , 'demo_image' ];
}
