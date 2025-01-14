<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JitsiMeeting extends Model
{

    protected $table = 'jitsimeetings';
    
    protected $fillable = ['meeting_id', 'owner_id', 'user_id','meeting_title', 'start_time', 'end_time','duration', 'jitsi_url',  'course_id', 'link_by', 'type', 'agenda', 'image','paid_meeting_toggle','paid_meeting_price'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault();
    }

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }

    
}
