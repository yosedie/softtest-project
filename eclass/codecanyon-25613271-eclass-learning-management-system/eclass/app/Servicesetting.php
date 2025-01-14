<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicesetting extends Model
{
    use HasFactory;
    protected $fillable = [ 'title', 'detail', 'image'];

}
