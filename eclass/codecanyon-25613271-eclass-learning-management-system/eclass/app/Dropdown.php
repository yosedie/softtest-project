<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Dropdown extends Model
{
    use HasFactory;
    protected $fillable = [
        'my_courses', 'my_wishlist', 'purchased_history','my_profile','flash_deal','donation'
    ,'my_wallet','affilate','compare','search_job','job_portal','form_enable'
    ,'my_leadership','affilate_dashboard','role_id'
    ];
    public function roles()
    {
        return $this->belongsTo('Spatie\Permission\Models\Role','role_id','id')->withDefault();
    }
}
