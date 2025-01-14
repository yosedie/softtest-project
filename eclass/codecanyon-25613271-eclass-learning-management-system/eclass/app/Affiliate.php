<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $table = 'affiliate';

    protected $fillable = ['ref_length', 'point_per_referral', 'points_to_reffered', 'image', 'text', 'status'];
}
