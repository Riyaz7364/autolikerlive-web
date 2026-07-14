<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameAiField extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_layer_id',
        'field_key',
        'field_type',
        'field_label',
        'field_placeholder',
        'field_default',
        'sort_order',
    ];

    public function layer(): BelongsTo
    {
        return $this->belongsTo(GameLayer::class, 'game_layer_id');
    }
}
