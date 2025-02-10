<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StripeService;
use App\Models\Vendor;
use App\Models\User;

class StripeController extends Controller
{
    private $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Create a standard Stripe Connect account for a user.
     */
    public function createStandardAccount($id)
    {
        $vendor = Vendor::findOrFail($id);
        $user = User::findOrFail($vendor->user_id); // Get user from request
        if (empty($vendor->stripe_account_id)) {
            $response = $this->stripeService->createStandardAccount($user);
            if ($response['success']) {
                $vendor->stripe_account_id = $response['account_id'];
                $vendor->save();
            }
        } else {
            $response['success'] = true;
            $response['account_id'] = $vendor->stripe_account_id;
        }

        return response()->json($response);
    }

    // /**
    //  * Generate an account onboarding link.
    //  */
    // public function createStandardAccountLink($accountId)
    // {
    //     $response = $this->stripeService->createStandardAccountLink($accountId);

    //     if ($response['success']) {
    //         $vendor = Vendor::where('stripe_account_id', $accountId)->first();
    //         $vendor->stripe_onboarding_url = $response['url'];
    //         $vendor->save();
    //     }

    //     return response()->json($response);
    // }
}
