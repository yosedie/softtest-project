<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorPlan extends Model
{
    use HasFactory;

    protected $table = 'instructor_plan';

    protected $fillable = [
         'title', 'detail', 'price', 'discount_price', 'type', 'status', 'preview_image', 'duration', 'duration_type', 'courses_allowed'
    ];
}
