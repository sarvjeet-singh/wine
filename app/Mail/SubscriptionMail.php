<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $vendor;
    public $plan;
    public $subscription;

    /**
     * Create a new message instance.
     */
    public function __construct($vendor, $plan, $subscription)
    {
        $this->vendor = $vendor;
        $this->plan = $plan;
        $this->subscription = $subscription;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Subscription Activated'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription_mail',
            with: [
                'vendorName' => $this->vendor->vendor_name,
                'vendorEmail' => $this->vendor->vendor_email,
                'subscriptionName' => $this->plan->name,
                'subscriptionPrice' => $this->subscription->price,
                'startDate' => $this->subscription->start_date->format('d M Y'),
                'endDate' => $this->subscription->end_date->format('d M Y'),
            ]
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
