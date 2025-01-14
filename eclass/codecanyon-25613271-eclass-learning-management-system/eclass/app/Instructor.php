<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;



class Instructor extends Model
{
    use HasRoles;

	protected $table = 'instructors';
	
    protected $fillable = [ 'user_id', 'fname', 'lname', 'email', 'dob', 'mobile', 'gender', 'detail', 'file', 'image', 'status', ];

    public function courses()
    {
        return $this->hasMany('App\Course','user_id');

    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    } 
}
