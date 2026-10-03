<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiktokTimer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'timer',
        'link',
    ];

    /**
     * Seconds left on this visitor's cooldown (IP, Telegram id or app uid).
     * Zero means ready for a new request.
     */
    public static function secondsLeft(string $identity): int
    {
        $row = static::where('id', $identity)->first();
        if (! $row) {
            return 0;
        }

        return max(0, (int) $row->timer - time());
    }

    /** Record a cooldown plus the submitted link (the fair-queue head). */
    public static function record(string $identity, string $link, int $waitMinutes): void
    {
        static::updateOrCreate(
            ['id' => $identity],
            ['timer' => time() + ($waitMinutes * 60), 'link' => $link],
        );
    }

    /** Newest submitted link across the free tools (the fair-queue head). */
    public static function lastLink(): ?string
    {
        $row = static::where('link', '!=', '')->orderByDesc('updated_at')->first();
        $link = $row ? trim((string) $row->link) : '';

        return $link !== '' ? $link : null;
    }
}
