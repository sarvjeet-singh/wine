<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tax;
use Stripe\Stripe;
use Stripe\TaxRate;

class TaxController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function index(Request $request)
    {
        $query = Tax::query();

        if ($request->has('status')) {
            $query->where('active', $request->status === 'active');
        }

        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $total = $query->count();
        $taxes = $query->paginate(10);

        return view('admin.stripe.taxes.index', compact('taxes', 'total'));
    }

    public function create()
    {
        return view('admin.stripe.taxes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'inclusive' => 'nullable|boolean'
        ]);

        try {
            // Create tax rate in Stripe
            $stripeTax = TaxRate::create([
                'display_name' => $request->name,
                'description' => $request->description,
                'percentage' => $request->percentage,
                'inclusive' => $request->inclusive ?? false,
            ]);

            // Create tax in database
            Tax::create([
                'name' => $request->name,
                'stripe_tax_id' => $stripeTax->id,
                'percentage' => $request->percentage,
                'description' => $request->description,
                'type' => $request->inclusive ?? false
            ]);

            return redirect()->route('admin.taxes.index')
                ->with('success', 'Tax rate created successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating tax rate: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $tax = Tax::findOrFail($id);
        return view('admin.stripe.taxes.create', compact('tax'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            // Update tax in database
            $tax = Tax::findOrFail($id);

            // Update tax rate in Stripe
            $stripeTax = TaxRate::retrieve($tax->stripe_tax_id);
            if ($stripeTax) {
                TaxRate::update($tax->stripe_tax_id, [
                    'display_name' => $request->name,
                    'description' => $request->description,
                ]);
            }
            $tax->update([
                'name' => $request->name,
                'description' => $tax->description,
            ]);

            return redirect()->route('admin.taxes.index')
                ->with('success', 'Tax rate updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating tax rate: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Fetch the tax rate from the database
            $tax = Tax::findOrFail($id);

            // Attempt to delete the tax rate from Stripe

            $stripeTaxRate = TaxRate::retrieve($tax->stripe_tax_id);

            // Delete the tax rate from Stripe
            if ($stripeTaxRate) {
                TaxRate::update($stripeTaxRate->id, ['active' => false]);
            }

            // Delete the tax rate from your local database
            $tax->delete();

            // Redirect with success message
            return redirect()->route('admin.taxes.index')
                ->with('success', 'Tax rate deleted successfully from both Stripe and your database');
        } catch (\Exception $e) {
            // Handle any other errors
            return back()->with('error', 'Error deleting tax rate: ' . $e->getMessage());
        }
    }
}
