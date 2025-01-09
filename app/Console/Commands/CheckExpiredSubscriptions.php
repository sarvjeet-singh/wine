<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WinerySubscription;
use App\Models\Vendor;
use Carbon\Carbon;

class CheckExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired subscriptions and update account status accordingly';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();

        // Fetch all expired subscriptions
        $expiredSubscriptions = WinerySubscription::where('end_date', '<', $now)
            ->where('status', 'active') // Only process active subscriptions
            ->get();

        foreach ($expiredSubscriptions as $subscription) {
            // Update subscription status
            $subscription->update(['status' => 'expired']);

            // Update vendor's account status
            $vendor = Vendor::find($subscription->vendor_id);
            if ($vendor) {
                $vendor->update([
                    'account_status' => 0, // 0 for inactive
                    'account_status_updated_at' => $now,
                ]);
            }
        }

        $this->info('Expired subscriptions processed successfully.');
        return Command::SUCCESS;
    }
}
