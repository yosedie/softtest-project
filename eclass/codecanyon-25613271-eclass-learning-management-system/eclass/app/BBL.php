<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BBL extends Model
{
    protected $table = 'bigbluemeetings';

    protected $fillable = ['meetingid','meetingname','modpw','attendeepw','welcomemsg','duration','setMaxParticipants','setMuteOnStart','allow_record','presen_name','instructor_id','detail','start_time', 'is_ended', 'link_by', 'course_id','paid_meeting_price','paid_meeting_toggle'];

    public function user(){
    	return $this->belongsTo('App\User','instructor_id','id')->withDefault();
    }

    public function course(){
    	return $this->belongsTo('App\Course','course_id','id')->withDefault();
    }
}
