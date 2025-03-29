<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\WinerySubscription;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Mail\SubscriptionConfirmationMail;
use Illuminate\Support\Facades\Mail;

class VendorSubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = WinerySubscription::with('vendor')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('winery_subscriptions')
                    ->whereIn('status', ['active', 'expired']) // Consider only active or expired
                    ->groupBy('vendor_id'); // Get the latest subscription per vendor
            })
            ->latest()
            ->paginate(10);
        return view('admin.vendor-subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        return view('admin.vendor-subscriptions.form', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,active,expired,canceled',
            'subscription_notes' => 'nullable|string',
            'price_type' => 'required|in:free,paid',
            'charge_amount' => 'required_if:price_type,paid',
        ]);

        $vendor = Vendor::findOrFail($request->vendor_id);

        // Find the monthly plan for the vendor type
        $plan = Plan::where('type', $vendor->vendor_type)
            ->where('interval', 'month')
            ->where('interval_count', 1)
            ->first();

        if (!$plan) {
            return back()->with('error', 'No valid monthly plan found for this vendor type.');
        }

        // Check if vendor already has an active subscription
        $existingSubscription = WinerySubscription::where('vendor_id', $vendor->id)
            ->where('status', 'active')
            ->first();

        if ($existingSubscription) {
            return back()->with('error', 'This vendor already has an active subscription.');
        }

        // Store the subscription with values from the database
        $subscription = WinerySubscription::create([
            'vendor_id' => $vendor->id,
            'stripe_subscription_id' => NULL, // From plans table
            'stripe_price_id' => $plan->stripe_plan_id, // If different, update accordingly
            'price' => $plan->price, // From plans table
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'subscription_notes' => $request->subscription_notes ?? '',
            'price_type' => $request->price_type,
            'charge_amount' => $request->charge_amount ?? 0,
        ]);

        // Send Email to Vendor
        Mail::to($vendor->vendor_email)->send(new SubscriptionConfirmationMail($vendor, $subscription));

        return redirect()->route('admin.vendor.subscriptions.index')->with('success', 'Subscription added successfully.');
    }

    public function edit(WinerySubscription $subscription)
    {
        $vendors = Vendor::all();
        return view('admin.vendor-subscriptions.form', compact('subscription', 'vendors'));
    }

    public function update(Request $request, WinerySubscription $subscription)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'status' => 'required|in:active,expired,canceled,pending',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'subscription_notes' => 'nullable|string',
            'price_type' => 'required|in:free,paid',
            'charge_amount' => 'required_if:price_type,paid',
        ]);

        $vendor = Vendor::findOrFail($request->vendor_id);

        // Find the monthly plan for the vendor type
        $plan = Plan::where('type', $vendor->vendor_type)
            ->where('interval', 'month')
            ->where('interval_count', 1)
            ->first();

        if (!$plan) {
            return back()->with('error', 'No valid monthly plan found for this vendor type.');
        }

        // Prevent multiple active subscriptions
        if ($request->status === 'active') {
            $existingActiveSubscription = WinerySubscription::where('vendor_id', $vendor->id)
                ->where('status', 'active')
                ->where('id', '!=', $subscription->id) // Exclude the current subscription
                ->first();

            if ($existingActiveSubscription) {
                return back()->with('error', 'This vendor already has an active subscription.');
            }
        }

        // Update subscription with values from database, not frontend
        $subscription->update([
            'vendor_id' => $vendor->id,
            'stripe_subscription_id' => NULL, // From plans table
            'stripe_price_id' => $plan->stripe_plan_id, // From plans table
            'price' => $plan->price, // From plans table
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'subscription_notes' => $request->subscription_notes ?? '',
            'price_type' => $request->price_type,
            'charge_amount' => $request->price_type === 'paid' ? $request->charge_amount : 0,
        ]);

        // Send Email to Vendor
        Mail::to($vendor->vendor_email)->send(new SubscriptionConfirmationMail($vendor, $subscription));

        return redirect()->route('admin.vendor.subscriptions.index')->with('success', 'Subscription updated successfully.');
    }

    public function destroy(WinerySubscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('admin.vendor.subscriptions.index')->with('success', 'Subscription deleted.');
    }
}
