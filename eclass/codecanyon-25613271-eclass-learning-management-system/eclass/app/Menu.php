<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
    	'link_by', 'title', 'position', 'page_id','url','status','position_menu','top','footer'
    ];
    public function page(){
    	return $this->belongsTo('App\Page','page_id','id')->withDefault();
    }

}
