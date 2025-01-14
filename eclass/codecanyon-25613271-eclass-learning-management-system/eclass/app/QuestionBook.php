<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBook extends Model
{
    use HasFactory;
    // The table associated with the model.
    protected $table = 'question_books';

    // The attributes that are mass assignable.
    protected $fillable = [
        'course_id',
        'type',
        'question',
        'answer',
        'option_one',
        'option_two',
        'option_three',
        'option_four',
        'correct_option',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id')->withDefault();
    }
}
