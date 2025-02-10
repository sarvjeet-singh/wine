<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendorInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiryData;
    public $vendor;

    /**
     * Create a new message instance.
     */
    public function __construct(array $inquiryData, $vendor)
    {
        $this->inquiryData = $inquiryData;
        $this->vendor = $vendor;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New User Inquiry from ' . $this->inquiryData['name'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.vendor.inquiry', // Ensure this Blade file exists in `resources/views/emails/`
            with: [
                'inquiry' => $this->inquiryData,
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
