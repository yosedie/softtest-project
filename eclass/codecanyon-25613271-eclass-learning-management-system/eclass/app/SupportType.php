<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportType extends Model
{
    use HasFactory;
    protected $table = 'support_types';
    protected $fillable = [
        'name',
    ];
}
