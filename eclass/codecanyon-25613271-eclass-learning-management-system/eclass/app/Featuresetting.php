<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Featuresetting extends Model
{
    use HasFactory;
    protected $fillable = [ 'title', 'detail', 'image'];
}
