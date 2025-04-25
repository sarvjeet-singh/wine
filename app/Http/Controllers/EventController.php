<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurativeExperience;
use App\Models\CustomerOrder;
use App\Models\EventOrderDetail;
use App\Models\EventGuestDetail;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\CustomerOrderTransaction;
use App\Models\VendorAccommodationMetadata;
use App\Models\VendorExcursionMetadata;
use App\Models\VendorLicenseMetadata;
use App\Models\VendorNonLicenseMetadata;
use App\Models\VendorWineryMetadata;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Customer as StripeCustomer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use App\Mail\EventBookingConfirmationMail;
use App\Mail\VendorNewBookingNotificationMail;

class EventController extends Controller
{
    public function events(Request $request)
    {
        $query = CurativeExperience::with(['category', 'vendor'])
            ->where('status', 'active')
            ->where('is_published', 1)
            ->whereHas('vendor', function ($q) {
                $q->whereIn('account_status', [1, 2]);
            });

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // ✅ Get today's events (start_date <= today AND end_date >= today)
        $todayEvents = (clone $query)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->limit(3)
            ->get();

        // ✅ Get tomorrow's events (start_date <= tomorrow AND end_date >= tomorrow)
        $tomorrowEvents = (clone $query)
            ->whereDate('start_date', '<=', $tomorrow)
            ->whereDate('end_date', '>=', $tomorrow)
            ->orderBy('start_date', 'asc')
            ->limit(3)
            ->get();

        // ✅ Get upcoming events (excluding today & tomorrow)
        $upcomingEvents = (clone $query)
            ->whereDate('start_date', '>', $tomorrow)
            ->whereDate('end_date', '>', $tomorrow)
            ->orderBy('start_date', 'asc')
            ->limit(3)
            ->get();
        $vendorCount = CurativeExperience::where('status', 'active')
            ->where('is_published', 1)
            ->whereHas('vendor', function ($q) {
                $q->whereIn('account_status', [1, 2]);
            })
            ->where(function ($query) {
                $query->whereDate('start_date', '>=', now())
                    ->orWhereDate('end_date', '>=', now());
            })
            ->count();
        return view('FrontEnd.events.index', compact('todayEvents', 'tomorrowEvents', 'upcomingEvents', 'vendorCount'));
    }

    public function getEvents(Request $request)
    {
        if (empty(array_filter($request->all(), function ($value) {
            return !is_null($value) && $value !== '' && $value !== [];
        }))) {
            $query = CurativeExperience::with('category', 'vendor')
                ->where('status', 'active') // Only active events
                ->where('is_published', 1)
                ->whereHas('vendor', function ($q) {
                    $q->whereIn('account_status', [1, 2]);
                });

            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $query->where('name', 'LIKE', "%{$searchTerm}%");
            }

            $today = Carbon::today();
            $tomorrow = Carbon::tomorrow();

            // ✅ Get today's events (start_date <= today AND end_date >= today)
            $todayEvents = (clone $query)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->orderBy('start_date', 'asc')
                ->limit(3)
                ->get();

            // ✅ Get tomorrow's events (start_date <= tomorrow AND end_date >= tomorrow)
            $tomorrowEvents = (clone $query)
                ->whereDate('start_date', '<=', $tomorrow)
                ->whereDate('end_date', '>=', $tomorrow)
                ->orderBy('start_date', 'asc')
                ->limit(3)
                ->get();

            // ✅ Get upcoming events (excluding today & tomorrow)
            $upcomingEvents = (clone $query)
                ->whereDate('start_date', '>', $tomorrow)
                ->whereDate('end_date', '>', $tomorrow)
                ->orderBy('start_date', 'asc')
                ->limit(3)
                ->get();
            return response()->json([
                'html' => view('FrontEnd.events.partials.unfiltered-events', compact('todayEvents', 'tomorrowEvents', 'upcomingEvents'))->render()
            ]);
        }

        $query = CurativeExperience::with('category')
            ->where('status', 'active') // Only active events
            ->where('is_published', 1)
            ->whereHas('vendor', function ($q) {
                $q->whereIn('account_status', [1, 2]);
            });

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // ✅ Handle Date Filters in One Query
        if ($request->has('date_filter') && is_array($request->date_filter) && !in_array('date_range', $request->date_filter)) {
            $query->where(function ($q) use ($request, $today, $tomorrow) {
                foreach ($request->date_filter as $filter) {
                    match ($filter) {
                        'today' => $q->orWhereBetween('start_date', [$today, $today]),
                        'tomorrow' => $q->orWhereBetween('start_date', [$tomorrow, $tomorrow]),
                        'upcoming' => $q->orWhere('start_date', '>', $tomorrow),
                        default => null
                    };
                }
            });
        }

        // ✅ Date Range Filter (Overrides predefined date filters)
        if ($request->filled(['start_date', 'end_date'])) {
            $startDate = Carbon::parse($request->start_date)->toDateString();
            $endDate = Carbon::parse($request->end_date)->toDateString();

            if ($startDate <= $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate]);
                });
            }
        }

        // ✅ Filter by Categories (Multiple Selection)
        if ($request->has('categories') && is_array($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        if ($request->has('genres') && is_array($request->genres)) {
            $query->whereIn('genre_id', $request->genres);
        }

        if ($request->has('event_ratings') && is_array($request->event_ratings)) {
            $query->whereIn('event_rating', $request->event_ratings);
        }

        // ✅ Price Filters
        if (!empty($request->min_price) && !empty($request->max_price)) {
            $query->where('is_free', 0); // Only paid events
            if ($request->has('min_price') && $request->has('max_price')) {
                $query->whereBetween('admittance', [$request->min_price, $request->max_price]);
            }
        }
        if (!empty($request->is_free) && $request->is_free == 1) {
            $query->where('is_free', 1); // Only free events
        }

        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = $request->q;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        // ✅ Fetch Events in One Query
        $events = $query->orderBy('start_date', 'asc')->get();

        return response()->json([
            'html' => view('FrontEnd.events.partials.filtered-events', compact('events'))->render()
        ]);
    }

    function searchEvents(Request $request)
    {
        $searchTerm = $request->query('term');

        $results = CurativeExperience::where('name', 'LIKE', "%{$searchTerm}%")
            ->where('status', 'active')
            ->where('is_published', 1)
            ->whereHas('vendor', function ($q) {
                $q->whereIn('account_status', [1, 2]);
            })
            ->limit(5)
            ->pluck('name', 'id'); // Only return titles

        return response()->json($results);
    }

    function eventDetails(Request $request, $id)
    {
        $event = CurativeExperience::with('category')
            ->where('is_published', 1)
            ->whereHas('vendor', function ($q) {
                $q->whereIn('account_status', [1, 2]);
            })
            ->where('status', 'active')
            ->where('id', $id)
            ->first();
        $vendor = $event->vendor()->first();
        if (!$event) {
            abort(404);
        }
        $relatedEvents = CurativeExperience::with('category')
            ->where('category_id', $event->category_id)
            ->where('id', '!=', $event->id)
            ->where('is_published', 1)
            ->whereHas('vendor', function ($q) {
                $q->whereIn('account_status', [1, 2]);
            })
            ->where('status', 'active') // Assuming there's an 'is_active' field to check if it's active
            ->where('start_date', '>=', now()) // Check if start_date is greater than today
            ->where('end_date', '>=', now()) // Check if end_date is greater than today
            ->limit(3)
            ->get();
        $totalTickets = getEventOrderTicketsUsedPerDay($event->id, Carbon::now()->format('Y-m-d'));
        $event->remaining_tickets = $event->inventory - $totalTickets;
        return view('FrontEnd.events.event-details', compact('event', 'relatedEvents', 'vendor'));
    }

    function eventCheckout($event_id)
    {
        if ($event_id == null) {
            return redirect()->route('events');
        }
        if (!is_numeric($event_id)) {
            return redirect()->route('events');
        }
        $event = CurativeExperience::with('category', 'vendor')->find($event_id);
        if ($event->vendor->account_status != 1) {
            return redirect()->route('events');
        }
        if (!$event) {
            return redirect()->route('events');
        }
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('login');
        }
        if (strtolower($event->vendor->vendor_type) == 'accommodation') {
            $metadata = VendorAccommodationMetadata::where('vendor_id', $event->vendor_id)->first();
        } else if (strtolower($event->vendor->vendor_type) == 'winery') {
            $metadata = VendorWineryMetadata::where('vendor_id', $event->vendor_id)->first();
        } else if (strtolower($event->vendor->vendor_type) == 'excursion') {
            $metadata = VendorExcursionMetadata::where('vendor_id', $event->vendor_id)->first();
        } else if (strtolower($event->vendor->vendor_type) == 'licensed') {
            $metadata = VendorLicenseMetadata::where('vendor_id', $event->vendor_id)->first();
        } else if (strtolower($event->vendor->vendor_type) == 'non-licensed') {
            $metadata = VendorNonLicenseMetadata::where('vendor_id', $event->vendor_id)->first();
        }
        $tax = $metadata->applicable_taxes_amount;
        $wallet = Wallet::where('customer_id', Auth::user()->id)->first();
        return view('FrontEnd.events.event-checkout', compact('event', 'wallet', 'tax'));
    }

    function eventCheckoutProcess(Request $request)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('login');
        }
        $validated = $request->validate([
            'event_id' => 'required|exists:curative_experiences,id',
            'wallet_used' => 'nullable|integer|min:0',
            'joinee' => ['nullable', 'array', 'min:1'],
            'joinee.*.email' => ['required', 'email'],
            'joinee.*.first_name' => ['required', 'string', 'max:255'],
            'joinee.*.last_name' => ['required', 'string', 'max:255'],
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'contact_number' => ['required', 'regex:/^\d{3}-\d{3}-\d{4}$/'],
            'street_address' => ['required', 'string'],
            'unit_suite' => ['nullable', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'string'],
            'state' => ['required_if:country,Canada', 'string'],
            'other_country' => ['nullable', 'string'],
            'other_state' => ['nullable', 'string'],
            'postal_code' => ['required', 'regex:/^[A-Z0-9 ]+$/i'],
        ]);

        $event = CurativeExperience::with('vendor')->find($validated['event_id']);
        $platform_fee = platformFeeCalculator($event->vendor, $event->admittance, $event->id);
        $noOfJoinees = !empty($validated['joinee']) ? count($validated['joinee']) : 0;
        $tickets =  1;
        if ($event->extension == '/Person') {
            $tickets = $noOfJoinees + 1;
        }
        $subtotal = $event->admittance + $platform_fee;
        if ($event->extension == '/Person') {
            $subtotal = $noOfJoinees * ($event->admittance + $platform_fee);
        }
        if (strtolower($event->vendor->vendor_type) == 'accommodation') {
            $metadata = VendorAccommodationMetadata::where('vendor_id', $event->vendor_id)->first();
        } else if (strtolower($event->vendor->vendor_type) == 'winery') {
            $metadata = VendorWineryMetadata::where('vendor_id', $event->vendor_id)->first();
        } else if (strtolower($event->vendor->vendor_type) == 'excursion') {
            $metadata = VendorExcursionMetadata::where('vendor_id', $event->vendor_id)->first();
        } else if (strtolower($event->vendor->vendor_type) == 'licensed') {
            $metadata = VendorLicenseMetadata::where('vendor_id', $event->vendor_id)->first();
        } else if (strtolower($event->vendor->vendor_type) == 'non-licensed') {
            $metadata = VendorNonLicenseMetadata::where('vendor_id', $event->vendor_id)->first();
        }
        $applicable_taxes_amount = $metadata->applicable_taxes_amount ?? 0;
        $walletUsed = $validated['wallet_used'] ?? 0;
        $wallet = Wallet::where('customer_id', Auth::guard('customer')->user()->id)->first();
        if ($walletUsed > 0 && ($wallet->balance >= $walletUsed)) {
            $walletUsed = $request->wallet_used;
        }
        if ($walletUsed > 0) {
            $subtotal = $subtotal - $walletUsed;
        }
        $tax = $subtotal * ($applicable_taxes_amount / 100);
        $total = $subtotal + $tax;
        DB::beginTransaction();
        try {
            // Step 1: Create Customer Order
            $customerOrder = CustomerOrder::create([
                'customer_id' => Auth::guard('customer')->user()->id, // Assuming authenticated user
                'vendor_id' => $event->vendor_id, // Change as needed
                'order_type' => 'event',
                'vendor_price' => $event->admittance,
                'listed_price' => $event->admittance + $platform_fee,
                'platform_fee_percentage' => platformFee($event->vendor,  $event->admittance, $event->id),
                'platform_service_fee' => $platform_fee,
                'sub_total' => $subtotal, // Replace with actual calculation
                'tax' => $tax, // Replace with actual calculation
                'wallet_amount' => $walletUsed,
                'total' => $total, // Replace with actual calculation
                'payment_method' => 'Credit Card', // Change dynamically
                'payment_status' => 'pending',
                'order_status' => 'pending',
            ]);

            // Step 2: Create Event Order Details
            $eventOrderDetail = EventOrderDetail::create([
                'customer_order_id' => $customerOrder->id,
                'event_id' => $validated['event_id'],
                'category_id' => $event->category_id, // Change dynamically
                'name' => $event->name, // Replace dynamically
                'price' => $event->admittance, // Replace dynamically
                'extension' => $event->extension, // Change dynamically
                'no_of_tickets' => $tickets,
                'start_date' => $event->start_date,
                'end_date' => $event->end_date,
                'booking_time' => $event->booking_time ?? null,
                'duration' => $event->duration, // Change dynamically
                'full_name' => $validated['fullname'],
                'email' => $validated['email'],
                'contact_number' => $validated['contact_number'],
                'street_address' => $validated['street_address'],
                'unit_suite' => $validated['unit_suite'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'] ?? null,
                'country' => $validated['country'],
                'postal_code' => $validated['postal_code'],
            ]);

            // Step 3: Insert Event Guest Details
            if (!empty($validated['joinee']) && count($validated['joinee']) > 0) {
                foreach ($validated['joinee'] as $joinee) {
                    // Validate email format and ensure it's provided
                    if (!filter_var($joinee['email'], FILTER_VALIDATE_EMAIL)) {
                        continue; // Skip this entry if email is invalid
                    }

                    // Check if the customer exists based on the email
                    $customer = Customer::where('email', $joinee['email'])->first();

                    // Create or update EventGuestDetail record
                    EventGuestDetail::create([
                        'customer_order_id' => $customerOrder->id,  // Ensure $customerOrder is defined
                        'event_id' => $validated['event_id'],  // Ensure $validated['event_id'] is available
                        'first_name' => $joinee['first_name'],
                        'last_name' => $joinee['last_name'],
                        'email' => $joinee['email'],
                        'customer_id' => $customer ? $customer->id : null,  // If customer exists, use customer ID, else set null
                    ]);
                }
            }

            DB::commit(); // Commit transaction
            $customer = Auth::guard('customer')->user();
            $order = CustomerOrder::find($customerOrder->id);
            $wallet_used = $order->wallet_amount;
            if ($wallet_used > 0) {
                app(WalletController::class)->useWallet($customer, $wallet_used, $order->id, 'event');
            }
            if ($total > 0) {
                return redirect()->route('events.payment', $customerOrder->id);
            }
            return redirect()->route('order.thankyou', ['id' => $customerOrder->id, 'orderType' => 'event']);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on failure
            return redirect()->back()->withErrors(['general' => $e->getMessage()]);
        }
    }

    function payment($order_id)
    {
        $order = CustomerOrder::find($order_id);
        if (!$order) {
            abort(404);
        }
        $vendor = Vendor::find($order->vendor_id);

        if ($order->payment_status != 'pending') {
            abort(404);
        }
        return view('FrontEnd.events.payment-page', compact('order', 'vendor'));
    }

    public function storeTransactionDetails(Request $request)
    {
        $order_id = $request->input('order_id');
        $payment_intent_id = $request->input('payment_intent_id');
        $transaction = CustomerOrderTransaction::where('order_id', $order_id)->first();
        $order = CustomerOrder::with('eventOrderDetail', 'vendor', 'customer')->find($order_id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = \Stripe\PaymentIntent::retrieve($payment_intent_id);

        $order->payment_status = 'processing';
        $order->save();

        $transactionData = [
            'order_id' => $order_id,
            'payment_type' => 'card',
            'transaction_id' => $paymentIntent->id,
            'transaction_status' => $paymentIntent->status,
            'transaction_amount' => $paymentIntent->amount / 100, // Convert cents to dollars
            'transaction_currency' => $paymentIntent->currency,
            'transaction_created_at' => Carbon::createFromTimestamp($paymentIntent->created)->toDateTimeString(),
            'card_brand_name' => $paymentIntent->charges->data[0]->payment_method_details->card->brand ?? null,
            'cc_number' => $paymentIntent->charges->data[0]->payment_method_details->card->last4 ?? null,
            'expiry' => ""
        ];

        if ($transaction) {
            // Update existing transaction
            $transaction->update($transactionData);
        } else {
            // Create a new transaction
            $transaction = CustomerOrderTransaction::create($transactionData);
        }

        if (!empty($transaction)) {
            $customer = Auth::guard('customer')->user();
            app(WalletController::class)->addCashback($customer, $transaction->transaction_amount, $order_id, 'event');
            Mail::to($customer->email)->send(new EventBookingConfirmationMail($order));
            if (!empty($order->vendor->vendor_email)) {
                Mail::to($order->vendor->vendor_email)->send(new VendorNewBookingNotificationMail($order));
            }

            return response()->json([
                'success' => true,
                'message' => 'Transaction details stored successfully.',
                'transaction' => $transaction
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to store transaction details.',
        ], 500);
    }

    public function thankYou(Request $request, $order_id)
    {
        if (Session::has('orderCompleted')) {
            Session::forget('orderCompleted');
        }
        return view('FrontEnd.thank-you', compact('order_id'));
    }

    public function orders()
    {
        // Apply middleware within the controller constructor instead of here
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return redirect()->route('customer.login')->withErrors('Please login to access your orders.');
        }
        $orders = CustomerOrder::with('eventOrderDetail')
            ->where('customer_id', Auth::guard('customer')
                ->user()->id)
            ->orderBy('id', 'desc')
            ->get();
        return view('UserDashboard.event-transactions', compact('orders'));
    }

    // public function eventOrderDetails($order_id)
    // {
    //     $customer = Auth::guard('customer')->user();

    //     if (!$customer) {
    //         return redirect()->route('customer.login')->withErrors('Please login to access your orders.');
    //     }
    //     $orders = CustomerOrder::with('eventOrderDetail', 'eventGuestDetails', 'vendor', 'eventOrderTransaction')->where('id', $order_id)
    //         ->first();
    //     return view('UserDashboard.event-order-details', compact('orders'));
    // }

    public function eventOrderDetail($order_id)
    {
        $order = CustomerOrder::with('eventOrderDetail', 'eventGuestDetails', 'vendor', 'eventOrderTransactions')->where('id', $order_id)->where('customer_id', Auth::guard('customer')->user()->id)
            ->first();
        return view('UserDashboard.event-order-detail', compact('order'));
    }

    public function vendorOrders($vendorid)
    {
        $vendor = Auth::guard('vendor')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login')->withErrors('Please login to access your orders.');
        }
        $orders = CustomerOrder::with('customer', 'eventOrderDetail')
            ->where('vendor_id', $vendorid)
            ->orderBy('id', 'desc')
            ->get();
        return view('VendorDashboard.event-transactions', compact('orders'));
    }

    // public function vendorEventOrderDetails($order_id, $vendorid)
    // {
    //     $this->middleware(['auth:vendor', 'checkPasswordUpdated', 'check.vendorid']);
    //     $order = EventOrderDetail::with('vendor')
    //         ->where('id', $order_id)
    //         ->where('customer_id', Auth::guard('customer')->user()->id)
    //         ->first();
    //     return view('VendorDashboard.event-order-details', compact('order'));
    // }

    public function vendorEventOrderDetail($order_id, $vendorid)
    {
        $vendor = Auth::guard('vendor')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login')->withErrors('Please login to access your orders.');
        }
        $order = CustomerOrder::with('eventOrderDetail', 'eventGuestDetails', 'vendor', 'eventOrderTransactions')
            ->where('id', $order_id)
            ->where('vendor_id', $vendorid)
            ->first();
        return view('VendorDashboard.event-order-detail', compact('order'));
    }

    public function checkEmailDetails(Request $request)
    {
        $email = $request->get('email');
        $user = Customer::where('email', $email)->first();

        if ($user) {
            return response()->json([
                'exists' => true,
                'first_name' => $user->firstname,
                'last_name' => $user->lastname,
            ]);
        }

        return response()->json(['exists' => false]);
    }
}
