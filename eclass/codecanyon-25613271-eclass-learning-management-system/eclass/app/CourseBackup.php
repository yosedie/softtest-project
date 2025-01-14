<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CourseBackup extends Model
{
    use HasTranslations;
    public $translatable = ['title', 'short_detail', 'detail', 'requirement'];
    protected $fillable = [
        'course_id','category_id', 'childcategory_id', 'subcategory_id', 'language_id', 'user_id', 'title', 'short_detail', 'detail',  'price', 'discount_price', 'day', 'video', 'video_url', 'featured', 'requirement', 'url', 'slug', 'status', 'preview_image', 'type', 'preview_type', 'duration', 'duration_type', 'instructor_revenue', 'involvement_request', 'refund_policy_id', 'assignment_enable', 'appointment_enable', 'certificate_enable', 'course_tags', 'level_tags', 'reject_txt', 'drip_enable', 'institude_id', 'country', 'other_cats'
    ];
    protected $casts = [
        'course_tags' => 'array',
        'other_cats' => 'array',
        'country' => 'array',
    ];

    public function toArray()
    {
        $attributes = parent::toArray();

        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }

        return $attributes;
    }
    
    public function chapter()
    {
        return $this->hasMany('App\CourseChapter', 'course_id');
    }

    public function whatlearns()
    {
        return $this->hasMany('App\WhatLearn', 'course_id');
    }

    public function progress()
    {
        return $this->hasMany('App\CourseProgress', 'course_id');
    }

    public function include()
    {
        return $this->hasMany('App\CourseInclude', 'course_id');
    }

    public function related()
    {
        return $this->hasMany('App\RelatedCourse', 'main_course_id');
    }

    public function question()
    {
        return $this->hasMany('App\Question', 'course_id');
    }

    public function answer()
    {
        return $this->hasMany('App\Answer', 'course_id');
    }

    public function announsment()
    {
        return $this->hasMany('App\Announcement', 'course_id');
    }

    public function courseclass()
    {
        return $this->hasMany('App\CourseClass', 'course_id');
    }

    public function favourite()
    {
        return $this->hasMany('App\Favourite', 'course_id');
    }

    public function wishlist()
    {
        return $this->hasMany('App\Wishlist', 'course_id');
    }

    public function review()
    {
        return $this->hasMany('App\ReviewRating', 'course_id');
    }

    public function reportreview()
    {
        return $this->hasMany('App\ReportReview', 'course_id');
    }

    public function instructor()
    {
        return $this->hasMany('App\Question', 'instructor_id');
    }

    public function order()
    {
        return $this->hasMany('App\Order', 'course_id');
    }

    public function pending()
    {
        return $this->hasMany('App\PendingPayout', 'course_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Categories', 'category_id', 'id')->withDefault();
    }

    public function sub_category()
    {
        return $this->belongsTo('App\SubCategory', 'subcategory_id', 'id')->withDefault();
    }

    public function language()
    {
        return $this->belongsTo('App\CourseLanguage', 'language_id', 'id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id')->withDefault();
    }

    public function policy()
    {
        return $this->belongsTo('App\RefundPolicy', 'refund_policy_id', 'id')->withDefault();
    }

    public function quiztopic()
    {
        return $this->hasMany('App\QuizTopic', 'course_id');
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('title', 'like', '%' . $searchTerm . '%');
    }
}
