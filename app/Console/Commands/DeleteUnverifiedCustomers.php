<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer; // Replace with the actual model name
use Carbon\Carbon;

class DeleteUnverifiedCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:delete-unverified';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes customers who haven\'t verified their email within 60 days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $thresholdDate = Carbon::now()->subDays(60);
        $unverifiedCustomers = Customer::whereNull('email_verified_at')
            ->where('created_at', '<=', $thresholdDate)
            ->get();

        $count = $unverifiedCustomers->count();

        if ($count > 0) {
            foreach ($unverifiedCustomers as $customer) {
                $customer->delete();
            }
            $this->info("Deleted {$count} unverified customers.");
        } else {
            $this->info("No unverified customers to delete.");
        }

        return Command::SUCCESS;
    }
}
