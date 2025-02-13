<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Tax;
use Stripe\Stripe;
use Stripe\Price;
use Stripe\TaxRate;
use Illuminate\Support\Facades\Log;

class StripeSyncService
{
    protected $stripe;

    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function syncPlans()
    {
        try {
            $synced = [];
            $hasMore = true;
            $startingAfter = null;
            while ($hasMore) {
                // Fetch all active prices from Stripe
                $params = [
                    'active' => true,
                    'type' => 'recurring',
                    'limit' => 100, // Get up to 100 prices per request
                    'expand' => ['data.product']
                ];

                if ($startingAfter) {
                    $params['starting_after'] = $startingAfter;
                }

                $stripePrices = Price::all($params);
                foreach ($stripePrices->data as $price) {
                    // Skip if product is not active
                    if (!$price->product->active) {
                        continue;
                    }

                    $plan = Plan::updateOrCreate(
                        ['stripe_plan_id' => $price->id],
                        [
                            'name' => $price->product->name,
                            'description' => $price->product->description,
                            'price' => $price->unit_amount / 100, // Convert cents to dollars
                            'interval' => $price->recurring->interval,
                            'interval_count' => $price->recurring->interval_count,
                            'stripe_product_id' => $price->product->id,
                            'currency' => $price->currency,
                            'metadata' => [
                                'stripe_metadata' => $price->product->metadata,
                                'features' => $price->product->features ?? []
                            ]
                        ]
                    );

                    $synced[] = $plan->id;
                }

                // Check if there are more pages
                $hasMore = $stripePrices->has_more;
                if ($hasMore) {
                    $startingAfter = end($stripePrices->data)->id; // Get last price ID
                }
            }

            // Optionally mark plans not in Stripe as inactive
            Plan::whereNotIn('id', $synced)->update(['status' => false]);

            return [
                'success' => true,
                'message' => 'Plans synced successfully',
                'synced_count' => count($synced)
            ];
        } catch (\Exception $e) {
            Log::error('Stripe plan sync failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to sync plans: ' . $e->getMessage()
            ];
        }
    }

    public function getStripePlan($planId)
    {
        try {
            $price = Price::retrieve([
                'id' => $planId,
                'expand' => ['product']
            ]);

            return [
                'success' => true,
                'plan' => $price
            ];
        } catch (\Exception $e) {
            Log::error('Failed to fetch Stripe plan: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch plan details'
            ];
        }
    }

    public function syncTaxes()
    {
        try {
            // Fetch all active tax rates from Stripe
            $stripeTaxes = TaxRate::all(['active' => true]);

            $synced = [];

            foreach ($stripeTaxes->data as $tax) {
                $localTax = Tax::updateOrCreate(
                    ['stripe_tax_id' => $tax->id],
                    [
                        'name' => $tax->display_name,
                        'description' => $tax->description,
                        'percentage' => $tax->percentage,
                        'type' => $tax->inclusive,
                        'active' => $tax->active
                    ]
                );

                $synced[] = $localTax->id;
            }

            // Optionally mark taxes not in Stripe as inactive
            Tax::whereNotIn('id', $synced)->update(['active' => false]);

            return [
                'success' => true,
                'message' => 'Taxes synced successfully',
                'synced_count' => count($synced)
            ];
        } catch (\Exception $e) {
            Log::error('Stripe tax sync failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to sync taxes: ' . $e->getMessage()
            ];
        }
    }

    public function getStripeTax($taxId)
    {
        try {
            $tax = TaxRate::retrieve($taxId);

            return [
                'success' => true,
                'tax' => $tax
            ];
        } catch (\Exception $e) {
            Log::error('Failed to fetch Stripe tax: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch tax details'
            ];
        }
    }
}
