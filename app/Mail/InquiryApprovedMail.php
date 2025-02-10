<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Inquiry;

class InquiryApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $vendor;

    /**
     * Create a new message instance.
     */
    public function __construct(Inquiry $inquiry, $vendor)
    {
        $this->inquiry = $inquiry;
        $this->vendor = $vendor;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Inquiry approved by ' . $this->vendor['vendor_name'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.customer.approved_inquiry', // Ensure this Blade file exists in `resources/views/emails/`
            with: [
                'inquiry' => $this->inquiry,
                'vendor' => $this->vendor
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
