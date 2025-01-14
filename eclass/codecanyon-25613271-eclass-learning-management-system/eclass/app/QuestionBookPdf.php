<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBookPdf extends Model
{
    use HasFactory;

    protected $table = 'question_book_pdfs';
    protected $fillable = ['course_id', 'file_name'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
