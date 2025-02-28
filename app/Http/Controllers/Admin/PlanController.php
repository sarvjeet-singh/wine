<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Tax;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Price;
use Stripe\Product;
use Stripe\TaxRate;
use Illuminate\Support\Str;
use Stripe\PaymentMethod;

class PlanController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function index(Request $request)
    {
        $query = Plan::with('taxes');

        if ($request->has('interval')) {
            $query->where('interval', $request->interval);
        }

        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $total = $query->count();
        $plans = $query->paginate(10);

        return view('admin.stripe.plans.index', compact('plans', 'total'));
    }

    /**
     * Display the form to create a new plan.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taxes = Tax::where('active', true)->get();
        $currencies = $this->supportedCurrencies();
        return view('admin.stripe.plans.create', compact('taxes', 'currencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:accommodation,winery,excursion,licensed,non-licensed',
            'features' => 'nullable|string',
            'interval' => 'required|in:day,week,month,year,3months,6months',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'currency' => [
                'required',
                'string',
                'in:' . implode(',', array_keys($this->supportedCurrencies()))
            ],
            'tax_ids' => 'array'
        ]);

        try {
            // Create Stripe Product
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            $interval_count = 1;
            $interval = $request->interval;
            if ($request->interval == '3months') {
                $interval = 'month';
                $interval_count = 3;
            } else if ($request->interval == '6months') {
                $interval_count = 6;
                $interval = 'month';
            }
            // Create Stripe Price
            $price = Price::create([
                'product' => $product->id,
                'unit_amount' => $request->price * 100, // Convert to cents
                'currency' => $request->currency,
                'recurring' => [
                    'interval' => $interval,
                    'interval_count' => $interval_count
                ]
            ]);

            // Create Plan in database
            $plan = Plan::create([
                'name' => $request->name,
                'stripe_plan_id' => $price->id,
                'price' => $request->price,
                'interval' => $request->interval,
                'interval_count' => $interval_count,
                'description' => $request->description,
                'type' => $request->type,
                'features' => $request->features,
                'currency' => $request->currency,
                'sort_order' => $request->sort_order
            ]);

            // Attach taxes to plan
            if ($request->has('tax_ids')) {
                $plan->taxes()->attach($request->tax_ids);
            }

            return redirect()->route('admin.plans.index')
                ->with('success', 'Plan created successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating plan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        if($plan->interval == 'month' &&  $plan->interval_count > 1){
            $plan->interval = $plan->interval_count . 'months';
        }
        $taxes = Tax::all(); // Fetch all available taxes
        $currencies = $this->supportedCurrencies();

        return view('admin.stripe.plans.create', compact('plan', 'taxes', 'currencies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'price' => 'required|numeric|min:0',
            'type' => 'required|in:accommodation,winery,excursion,licensed,non-licensed',
            'features' => 'nullable|string',
            // 'interval' => 'required|in:day,week,month,year,3months,6months',
            'description' => 'nullable|string',
            'tax_ids' => 'array'
        ]);

        try {
            $plan = Plan::findOrFail($id);

            // Update interval and interval count
            $interval_count = 1;
            $interval = $request->interval;
            if ($request->interval == '3months') {
                $interval = 'month';
                $interval_count = 3;
            } elseif ($request->interval == '6months') {
                $interval = 'month';
                $interval_count = 6;
            }

            $stripePrice = Price::retrieve($plan->stripe_plan_id);

            if (!$stripePrice) {
                return back()->with('error', 'Stripe Price not found.');
            }

            // Extract the associated Product ID from the Price object
            $stripeProductId = $stripePrice->product;

            if (!$stripeProductId || !Str::startsWith($stripeProductId, 'prod_')) {
                return back()->with('error', 'Invalid or missing Stripe Product ID.');
            }

            // Update Stripe Product
            $product = Product::update($stripeProductId, [
                'name' => $request->name,
                'description' => $request->description,
            ]);

            // Create a new Stripe Price (since Stripe doesn't allow price updates)
            // $price = Price::create([
            //     'product' => $plan->stripe_product_id,
            //     'unit_amount' => $request->price * 100, // Convert to cents
            //     'currency' => 'usd',
            //     'recurring' => [
            //         'interval' => $interval,
            //         'interval_count' => $interval_count
            //     ]
            // ]);

            // Update Plan in database
            $plan->update([
                'name' => $request->name,
                'features' => $request->features,
                'type' => $request->type,
                'sort_order' => $request->sort_order,
                // 'stripe_plan_id' => $price->id, // Assign new Stripe price ID
                // 'price' => $request->price,
                // 'interval' => $request->interval,
                // 'interval_count' => $interval_count,
                'description' => $request->description
            ]);

            // Sync taxes
            $plan->taxes()->sync($request->tax_ids ?? []);

            return redirect()->route('admin.plans.index')
                ->with('success', 'Plan updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating plan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $plan = Plan::findOrFail($id);

            // Retrieve the Stripe Price using the stored price ID
            $stripePrice = Price::retrieve($plan->stripe_plan_id);

            if (!$stripePrice) {
                return back()->with('error', 'Stripe Price not found.');
            }

            // Extract the associated Product ID from the Price object
            $stripeProductId = $stripePrice->product;

            if (!$stripeProductId || !Str::startsWith($stripeProductId, 'prod_')) {
                return back()->with('error', 'Invalid or missing Stripe Product ID.');
            }

            // Archive the Price instead of deleting it
            Price::update($stripePrice->id, ['active' => false]);

            // Archive the Product instead of deleting it
            Product::update($stripeProductId, ['active' => false]);

            // Delete the plan from the database
            $plan->delete();

            return redirect()->route('admin.plans.index')
                ->with('success', 'Plan archived and removed from database successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting plan: ' . $e->getMessage());
        }
    }

    private function supportedCurrencies()
    {
        return [
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'GBP' => 'British Pound',
            'INR' => 'Indian Rupee',
            'AUD' => 'Australian Dollar',
            'CAD' => 'Canadian Dollar',
            'JPY' => 'Japanese Yen',
            'CNY' => 'Chinese Yuan',
            'MXN' => 'Mexican Peso',
            'RUB' => 'Russian Ruble',
            'BRL' => 'Brazilian Real'
        ];
    }
}
