<?php

namespace App\Http\Controllers;

use App\Services\StripeSubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Vendor;
use App\Models\Plan;
use App\Models\WinerySubscription;

use Exception;

class SubscriptionController extends Controller
{
    protected $stripeService;

    public function __construct(StripeSubscriptionService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function index($vendorid)
    {
        $vendor = Vendor::find($vendorid);
        $activeSubscription = WinerySubscription::where('vendor_id', $vendorid)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->first();
        $plans = Plan::where('status', 1)
        ->where('type', strtolower($vendor->vendor_type))
        ->orderBy('sort_order', 'asc')
        ->get();
        // print_r($activeSubscriptions); die;
        $products = $this->stripeService->getProducts();
        // print_r($products); die;
        return view('VendorDashboard.winery-subscriptions.index', compact('products', 'vendorid', 'activeSubscription', 'vendor', 'plans'));
    }

    public function createPaymentIntent(Request $request, $vendorid)
    {
        $price_id = $request->price_id;
        $plan = $request->plan;
        $vendor = Vendor::find($vendorid);
        return $this->stripeService->createPaymentIntent($vendor, $price_id, $plan);
    }

    public function updateStatus(Request $request)
    {
        $subscription = WinerySubscription::findOrFail($request->subscription_id);
        $subscription->update(['status' => $request->status]);

        return response()->json(['message' => 'Subscription status updated successfully.']);
    }

    public function cancelSubscription(Request $request)
    {
        // Retrieve the subscription ID from the request
        $subscriptionId = $request->input('subscription_id');

        // Use the StripeService to cancel the subscription
        $result = $this->stripeService->cancelSubscription($subscriptionId);

        // Return a JSON response based on the result
        if ($result['status'] === 'success') {
            return response()->json($result, 200);
        } else {
            return response()->json($result, 400);
        }
    }

    public function changeSubscription(Request $request)
    {
        try {
            $user = Auth::user(); // Ensure user is authenticated
            $vendorId = $request->input('vendor_id');
            $newPlanId = $request->input('new_plan_id');
            $newPrice = $request->input('new_price');

            if (!$vendorId || !$newPlanId) {
                throw new Exception("Vendor ID and New Plan ID are required.");
            }

            // Attempt to change the subscription
            $newSubscription = $this->stripeService->changeSubscription($user, $vendorId, $newPlanId, $newPrice);

            return response()->json(['subscription' => $newSubscription], 200);
        } catch (Exception $e) {
            Log::error('Subscription change failed: ' . $e->getMessage());
            return response()->json(['error' => 'Subscription change failed', 'message' => $e->getMessage()], 400);
        }
    }

    public function showSubscriptionDetail(Request $request, $vendorid)
    {
        $activeSubscription = WinerySubscription::where('vendor_id', $vendorid)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->first();
        $subscriptionId = $activeSubscription->stripe_subscription_id;
        // Call the method in StripeService
        $response = $this->stripeService->getSubscriptionDetails($subscriptionId);

        return response()->json($response);
    }
}
