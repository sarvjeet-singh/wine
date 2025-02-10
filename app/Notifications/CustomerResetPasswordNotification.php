<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomerResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = url("/customer/password/reset/{$this->token}?email=" . urlencode($notifiable->email));

        return (new MailMessage)
            ->subject('Reset Password Notification')
            ->view('emails.customer.reset-password', [
                'resetUrl' => $resetUrl,
                'user' => $notifiable,
            ]); // Use your custom template
    }
}
