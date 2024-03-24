<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'emoji',
        'number_id',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function number()
    {
        return $this->belongsTo(Number::class);
    }
}
