<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSupport extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
        'priority',
        'subject',
        'message',
        'ticket_id',
        'status',
        'image',
        'user_id',

    ];

    public function SupportType()
    {
        return $this->belongsTo(SupportType::class, 'category');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
