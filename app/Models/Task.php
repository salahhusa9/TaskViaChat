<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'task_status_id',
        'whatsapp_session_id',
        'whatsapp_message_id',
        'whatsapp_chat_id',
    ];

    public function status()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function whatsapp_session()
    {
        return $this->belongsTo(WhatsappSession::class);
    }

    public function whatsapp_message()
    {
        return $this->belongsTo(WhatsappMessage::class);
    }
}
