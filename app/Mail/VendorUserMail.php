<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userData;
    public $viewName;
    public $subject;
    public $password;

    /**
     * Create a new message instance.
     *
     * @param array $inquiryData
     * @param string $inquiryType
     */
    public function __construct(object $userData, string $password, string $viewName, string $subject)
    {
        $this->userData = $userData;
        $this->viewName = $viewName;
        $this->subject = $subject;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view($this->viewName)
            ->with([
                'userData' => $this->userData,
                'password' => $this->password
            ]);
    }
}
