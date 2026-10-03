<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        $flush = function () {
            \Illuminate\Support\Facades\Cache::forget('tags_all');
        };
        static::saved($flush);
        static::deleted($flush);
    }
}
