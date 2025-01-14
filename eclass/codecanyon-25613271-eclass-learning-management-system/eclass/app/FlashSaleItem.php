<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{

    protected $fillable = [
        'sale_id','course_id','discount','discount_type'
    ];

    public function sale(){
        return $this->belongsTo(Flashsale::class,'sale_id','id')->withDefault();
    }

    public function courses(){
        return $this->belongsTo(Course::class,'course_id','id')->withDefault();
    }

}
