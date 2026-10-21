<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TempInbox extends Model
{
    protected $fillable = [
        'uuid',
        'inbox_token',
        'email',
        'local_part',
        'domain',
        'expires_at',
        'last_seen_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($inbox) {
            if (! $inbox->uuid) {
                $inbox->uuid = (string) Str::orderedUuid();
            }
        });
    }

    public function isActive(): bool
    {
        return $this->expires_at === null || $this->expires_at->isFuture();
    }

    public function scopeActive($query)
    {
        return $query->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()));
    }

    /**
     * Private pusher channel this inbox listens on.
     */
    public function channel(): string
    {
        return "inbox.{$this->inbox_token}";
    }

    /**
     * Record that the inbox was just used (feeds the watch sweep window).
     */
    public function touchActivity(): void
    {
        $this->forceFill(['last_seen_at' => now()])->saveQuietly();
    }
}
