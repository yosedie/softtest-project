<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    use HasFactory;

	protected $table = 'notice_boards';
    protected $fillable = [
        'course_id', 'title', 'content','status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id')->withDefault();
    }
}
