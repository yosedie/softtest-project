<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followers extends Model
{
    use HasFactory;

    protected $table = 'followers';
	
    protected $fillable = [ 'user_id', 'follower_id'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }
}
