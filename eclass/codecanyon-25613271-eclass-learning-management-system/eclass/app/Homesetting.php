<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homesetting extends Model
{
    use HasFactory;
    protected $fillable = [
    'fact_enable', 'discount_enable', 'purchase_enable','recentcourse_enable','featured_enable','bundle_enable'
    ,'bestselling_enable','batch_enable','livemeetings_enable','blog_enable','became_enable','featuredcategories_enable'
    ,'testimonial_enable','video_enable','instructor_enable','trusted_enable','newsletter_enable','discount_badget_enable','institute_enable','get_enable'
    ,'service_enable','feature_enable'
    ];
}
