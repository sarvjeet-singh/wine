<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Vendor;
use App\Models\WinerySubscription;

class SubscriptionConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Vendor $vendor;
    public WinerySubscription $subscription;

    /**
     * Create a new message instance.
     */
    public function __construct(Vendor $vendor, WinerySubscription $subscription)
    {
        $this->vendor = $vendor;
        $this->subscription = $subscription;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Confirmation'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.vendor.subscription_confirmation',
            with: [
                'vendorName' => $this->vendor->name,
                'startDate' => $this->subscription->start_date,
                'endDate' => $this->subscription->end_date,
                'priceType' => ucfirst($this->subscription->price_type),
                'chargeAmount' => $this->subscription->charge_amount,
            ]
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
