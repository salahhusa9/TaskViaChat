<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappMessageReaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'whatsapp_message_id',
        'message_id', // native message id from api
        'reaction',
    ];

    public function whatsappMessage()
    {
        return $this->belongsTo(WhatsappMessage::class);
    }
}
