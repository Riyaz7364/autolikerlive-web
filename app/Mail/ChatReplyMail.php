<?php

namespace App\Mail;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChatReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ChatConversation $conversation,
        public ChatMessage $message,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-replay@autolikerlive.com', 'Support - AutoLikerLive'),
            subject: 'New reply from AutoLikerLive support',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.chat_reply',
            with: [
                'name' => $this->conversation->name,
                'body' => $this->message->body,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
