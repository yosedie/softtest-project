<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColorOption extends Model
{
    protected $table = 'color_options';

    protected $fillable = [ 
    	'blue_bg',
    	'red_bg',
    	'grey_bg',
    	'light_grey_bg',
    	'black_bg',
    	'white_bg',
    	'dark_red_bg',
    	'black_text',
    	'light_grey_text',
    	'dark_grey_text',
    	'red_text',
    	'blue_text',
    	'dark_blue_text',
    	'white_text',
    	'linear_bg_one',
    	'linear_bg_two',
    	'linear_reverse_bg_one',
    	'linear_reverse_bg_two',
    	'linear_about_bg_one',
    	'linear_about_bg_two',
    	'linear_about_bluebg_one',
    	'linear_about_bluebg_two',
    	'linear_career_bg_one',
    	'linear_career_bg_two'

    ];
}
