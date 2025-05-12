<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vendor;
use Stripe\Stripe;
use Stripe\Account;
use Illuminate\Support\Facades\Log;
use App\Mail\VendorPayoutReadyMail;
use Illuminate\Support\Facades\Mail;

class CheckStripePayoutStatus extends Command
{
    protected $signature = 'stripe:check-payout-status';
    protected $description = 'Check all statuses of connected Stripe accounts';

    public function handle()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $vendors = Vendor::whereNotNull('stripe_account_id')
            ->where(function ($query) {
                $query->where('stripe_onboarding_account_status', '!=', 'active')
                    ->orWhereNull('stripe_onboarding_account_status');
            })
            ->get();


        foreach ($vendors as $vendor) {
            try {
                $account = Account::retrieve($vendor->stripe_account_id);

                // Stripe account statuses
                $chargesEnabled = $account->charges_enabled;
                $payoutsEnabled = $account->payouts_enabled;
                $detailsSubmitted = $account->details_submitted;
                $requirements = $account->requirements->currently_due;

                // Determine onboarding status
                if ($chargesEnabled && $payoutsEnabled && $detailsSubmitted) {
                    $status = 'active';
                } elseif (!$chargesEnabled || !$payoutsEnabled) {
                    $status = 'restricted';
                } elseif (count($requirements) > 0) {
                    $status = 'pending_verification';
                } else {
                    $status = 'incomplete';
                }

                // Update vendor status in DB
                $vendor->update(['stripe_onboarding_account_status' => $status]);

                if ($status == 'active') {
                    // Send email only if it transitioned to active (optional safeguard)
                    if(!empty($vendor->vendor_email)) {
                        Mail::to($vendor->vendor_email)->send(new VendorPayoutReadyMail($vendor));
                    } else {
                        Mail::to(env('ADMIN_EMAIL'))->send(new VendorPayoutReadyMail($vendor));
                    }
                }

                Log::info("Vendor {$vendor->id} status updated to: {$status}");
            } catch (\Exception $e) {
                Log::error("Error checking Stripe status for Vendor {$vendor->id}: " . $e->getMessage());
            }
        }

        $this->info('Stripe status check completed.');
    }
}
