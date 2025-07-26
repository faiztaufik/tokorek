<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'message',
        'is_admin',
        'session_id'
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];
}
