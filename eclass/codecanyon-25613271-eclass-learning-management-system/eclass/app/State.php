<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';

    public function country()
    {
    	return $this->belongsTo('App\Country','country_id', 'country_id')->withDefault();
    }

    public function city(){

    	return $this->hasMany('App\City','state_id');
    }
}
