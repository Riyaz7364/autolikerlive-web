<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'og_title',
        'og_description',
        'bg_image',
        'canvas_w',
        'canvas_h',
        'bg_color',
        'status',
    ];

    public function layers(): HasMany
    {
        return $this->hasMany(GameLayer::class)->orderBy('sort_order');
    }

    public function visibleLayers(): HasMany
    {
        return $this->hasMany(GameLayer::class)->where('visible', true)->orderBy('sort_order');
    }
}
