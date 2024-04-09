<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappMessageReaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id', // native message id from api
        'reaction',

        'from',       // 11111111110@c.us
        'to',         // 11111111111@c.us

        'session_id', // 11111111111@c.us
        'session_name', // default
    ];
}
