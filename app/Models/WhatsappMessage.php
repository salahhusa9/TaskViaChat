<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'whatsapp_session_id',
        'message_id',
        'timestamp',
        'from',
        'to',
        'body',
        'description',
        'hasMedia',
    ];

    protected $casts = [
        'hasMedia' => 'boolean',
    ];

    public function whatsappSession()
    {
        return $this->belongsTo(WhatsappSession::class);
    }

    public function reaction()
    {
        return $this->hasMany(WhatsappMessageReaction::class);
    }

    public function task()
    {
        return $this->hasOne(Task::class);
    }
}
