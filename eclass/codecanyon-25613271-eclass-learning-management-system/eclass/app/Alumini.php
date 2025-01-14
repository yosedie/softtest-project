<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumini extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'status', 'url'];
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }
}
