<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\WeeklyRegisteredUsersMail;
use Illuminate\Support\Facades\Mail;

class SendWeeklyRegisteredUsers extends Command
{
    protected $signature = 'email:weekly-registered-users';
    protected $description = 'Send a weekly email with all registered users with the role "Member".';

    public function handle()
    {
        // Fetch users with role 'Member' registered in the past week
        $users = User::where('role', 'Member')
            ->whereBetween('created_at', [now()->subWeek(), now()])
            ->select('firstname', 'lastname', 'email', 'contact_number')
            ->get();

        if ($users->isEmpty()) {
            $this->info('No users found for this week.');
            return 0;
        }

        // Send the email
        $recipientEmail = 'sarvjeetsingh.slinfy@gmail.com'; // Replace with your recipient's email
        \Illuminate\Support\Facades\Mail::to($recipientEmail)->send(new \App\Mail\WeeklyRegisteredUsersMail($users));

        $this->info('Weekly registered users email sent successfully.');
        return 0;
    }
}
