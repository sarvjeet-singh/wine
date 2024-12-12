<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $adminData;
    public $viewName;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param array $inquiryData
     * @param string $inquiryType
     */
    public function __construct(array $adminData, string $viewName, string $subject)
    {
        $this->adminData = $adminData;
        $this->viewName = $viewName;
        $this->subject = $subject;
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
                'adminData' => $this->adminData,
            ]);
    }
}
