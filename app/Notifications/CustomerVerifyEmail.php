<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class CustomerVerifyEmail extends BaseVerifyEmail
{
    /**
     * Get the verification email message.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->view('emails.customer-verify-email', [
                'verificationUrl' => $verificationUrl,
                'notifiable' => $notifiable,
                'username' => $notifiable->firstname
            ]);
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'customer.verify.email', // Name of the verification route
            now()->addMinutes(config('auth.verification.expire', 60)), // Link expiration time from config
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()), // Email hash
            ]
        );
    }
}
