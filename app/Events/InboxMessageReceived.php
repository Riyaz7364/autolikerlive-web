<?php

namespace App\Events;

use App\Models\TempInbox;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Pushed over Reverb to the private channel of a temp inbox the moment a
 * new message is detected (either by the inbox owner fetching, or by the
 * scheduled tempmail:watch sweep). Only holders of the inbox token can
 * subscribe to this channel.
 */
class InboxMessageReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public TempInbox $inbox, public array $message) {}

    public function broadcastOn(): array
    {
        return [new PrivateChannel($this->inbox->channel())];
    }

    public function broadcastAs(): string
    {
        return 'inbox.message';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message['id'] ?? null,
            'email' => $this->inbox->email,
            'from' => $this->message['from'] ?? null,
            'from_email' => $this->message['from_email'] ?? null,
            'subject' => $this->message['subject'] ?? null,
            'receivedAt' => $this->message['receivedAt'] ?? null,
            'html' => (bool) ($this->message['html'] ?? false),
        ];
    }
}
