<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoDirectory extends Model
{
    use HasFactory;

    protected $table = 'seo_directory';

    protected $fillable = [
        'city', 'detail', 'status' ];
}
