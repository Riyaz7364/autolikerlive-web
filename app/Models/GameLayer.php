<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameLayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'type',
        'source_type',
        'prompt_label',
        'content',
        'x',
        'y',
        'w',
        'h',
        'rotation',
        'font_family',
        'font_size',
        'font_color',
        'text_align',
        'wrap_width',
        'method_name',
        'method_label',
        'fallback_text',
        'fail_behavior',
        'sort_order',
        'visible',
        'shape_filter',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
