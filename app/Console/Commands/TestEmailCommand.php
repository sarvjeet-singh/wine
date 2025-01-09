<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify the email service is working';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Define recipient and email content
        $recipient = env('ADMIN_EMAIL'); // Replace with the actual test email address
        $subject = 'Daily Email System Test - ' . date('Y-m-d'); ;
        $message = 'This is a daily test email to confirm that the email system is functioning correctly. <br><br><b>Status</b>: Successful';
        

        // Send the email
        try {
            Mail::raw($message, function ($mail) use ($recipient, $subject) {
                $mail->to($recipient)->subject($subject);
            });

            $this->info('Test email sent successfully.');
        } catch (\Exception $e) {
            $this->error('Failed to send test email: ' . $e->getMessage());
        }

        return 0;
    }
}