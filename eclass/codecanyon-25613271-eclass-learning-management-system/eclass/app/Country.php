<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable=[
	
		'iso', 'name', 'nicename', 'iso3', 'numcode'

	];

	public function states(){
    	return $this->hasMany('App\State','country_id');
    }

    public function city(){
    	return $this->hasMany('App\City','country_id');
    }
}
