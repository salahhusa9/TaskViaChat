<?php

namespace App\Models;

use App\Enums\WhatsappSessionServerStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappSessionServer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'host',
        'port',
        'secret',
        'status',
    ];

    protected $casts = [
        'status' => WhatsappSessionServerStatus::class,
    ];

    public function whatsappSessions()
    {
        return $this->hasMany(WhatsappSession::class);
    }
}
