<?php

namespace App\Models;

use App\Enums\WhatsappSessionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',          // id of session in server    ex: 1234567890@c.us
        'session_name',       // name of session in server   ex: defualt
        'session_push_name', // push name of session,        ex: salah eddine bendyab
        'phone_number',     // phone number of session       ex: 1234567890
        'status',
        'whatsapp_session_server_id',
        'user_id'
    ];

    protected $appends = [
        'status_description',
    ];

    protected $casts = [
        'status' => WhatsappSessionStatus::class,
    ];

    public function getStatusDescriptionAttribute()
    {
        return $this->status->getDescriptionForUser();
    }

    public function whatsappSessionServer()
    {
        return $this->belongsTo(WhatsappSessionServer::class);
    }

    public function taskStatuses()
    {
        return $this->hasMany(TaskStatus::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function messages()
    {
        return $this->hasMany(WhatsappMessage::class);
    }
}
