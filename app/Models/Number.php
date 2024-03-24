<?php

namespace App\Models;

use App\Enums\NumberStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'status',
    ];

    protected $appends = [
        'status_description',
    ];

    protected $casts = [
        'status' => NumberStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusDescriptionAttribute()
    {
        return $this->status->getDescriptionForUser();
    }
}
