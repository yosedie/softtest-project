<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mailchimpsetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'MAILCHIMP_LIST_ID','MAILCHIMP_APIKEY'
    ];
}
