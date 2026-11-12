<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaImage extends Model
{
    protected $fillable = [
        'key',
        'label',
        'image',
        'is_dynamic',
    ];

    protected $casts = [
        'is_dynamic' => 'boolean',
    ];
}
