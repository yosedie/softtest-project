<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewHelpful extends Model
{
	protected $table = 'review_helpfuls';
	
    protected $fillable = ['course_id', 'user_id', 'review_id', 'helpful', 'review_like', 'review_dislike'];
}
