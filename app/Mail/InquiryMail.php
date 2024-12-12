<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiryData;
    public $viewName;

    /**
     * Create a new message instance.
     *
     * @param array $inquiryData
     * @param string $inquiryType
     */
    public function __construct(array $inquiryData, string $viewName)
    {
        $this->inquiryData = $inquiryData;
        $this->viewName = $viewName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Inquiry Received')
            ->view($this->viewName)
            ->with([
                'inquiryData' => $this->inquiryData,
            ]);
    }
}
