<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use App\Models\CurativeExperience;

class AdminEventSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $event;

    /**
     * Create a new message instance.
     */
    public function __construct(CurativeExperience $event)
    {
        $this->event = $event;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨 New Event Submitted for Approval: ' . $this->event->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.event-approval',
            with: [
                'event' => $this->event,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
