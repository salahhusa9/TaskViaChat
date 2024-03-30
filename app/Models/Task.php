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
        'status_id',
        'whatsapp_session_id'
    ];

    public function status()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function whatsapp_session()
    {
        return $this->belongsTo(WhatsappSession::class);
    }
}
