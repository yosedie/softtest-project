<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allcity extends Model
{
    protected $table = 'allcities';

    public function state(){
    	return $this->belongsTo('App\Allstate','state_id','id')->withDefault();
    }
}
