<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vendorData;
    public $viewName;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param array $inquiryData
     * @param string $inquiryType
     */
    public function __construct(array $vendorData, string $viewName, string $subject)
    {
        $this->vendorData = $vendorData;
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
                'vendorData' => $this->vendorData,
            ]);
    }
}
