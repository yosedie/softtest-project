<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flashsale extends Model
{
    protected $fillable = [
        'title','start_date','end_date','background_image','detail','status'
    ];

    public function saleitems(){
        return $this->hasMany(FlashSaleItem::class,'sale_id');
    }
}
