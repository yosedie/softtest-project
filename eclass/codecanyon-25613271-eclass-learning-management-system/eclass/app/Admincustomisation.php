<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admincustomisation extends Model
{
    use HasFactory;
    protected $fillable = ['bg_grey_color', 'bg_white_color','text-grey-color','text_dark_color','text_white_color','text_blue_color'];

}
