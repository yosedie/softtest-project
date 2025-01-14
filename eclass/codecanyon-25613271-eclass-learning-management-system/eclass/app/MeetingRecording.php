<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingRecording extends Model
{
    use HasFactory;

    protected $table = 'meeting_recordings';

    protected $fillable = ['title', 'url'];
}
