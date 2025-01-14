<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $table = 'advertisements'; 

    protected $fillable = [
        'image1',
        'image2', 
        'status', 
        'link_by1', 
        'link_by2', 
        'course_id1', 
        'course_id2', 
        'url1', 
        'url2',
        'position',
        'status'
    ];
}
