<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniqueLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'session',
        'data',
        'user_id',
        'ip',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
