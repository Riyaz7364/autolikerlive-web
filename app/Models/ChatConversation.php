<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatConversation extends Model
{
    protected $fillable = [
        'uuid', 'guest_token', 'name', 'email', 'page_url', 'referrer',
        'ip', 'country', 'city', 'user_agent', 'browser', 'browser_version',
        'platform', 'device', 'status', 'blocked_reason', 'blocked_at',
        'admin_unread', 'guest_unread', 'last_message_at',
        'last_admin_seen_at', 'last_guest_seen_at',
    ];

    protected $casts = [
        'blocked_at' => 'datetime',
        'last_message_at' => 'datetime',
        'last_admin_seen_at' => 'datetime',
        'last_guest_seen_at' => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id')->orderBy('id');
    }

    public function isBlocked(): bool
    {
        return $this->status === 'blocked';
    }

    public function scopeActive($q)
    {
        return $q->whereIn('status', ['open', 'pending']);
    }
}
