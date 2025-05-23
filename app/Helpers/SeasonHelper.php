<?php

namespace App\Helpers;

use App\Models\PublishSeason;
use App\Models\Vendor;
use App\Models\VendorPricing;
use Carbon\Carbon;

class SeasonHelper
{
    public static function getSeasonAndPrice($currentDate, $vendorId)
    {
        // Parse the date using Carbon
        $currentDate = Carbon::parse($currentDate);

        // Define season date ranges
        $seasons = [
            'winter' => ['start' => '12-21', 'end' => '03-20'],
            'spring' => ['start' => '03-21', 'end' => '06-20'],
            'summer' => ['start' => '06-21', 'end' => '09-20'],
            'fall' => ['start' => '09-21', 'end' => '12-20'],
        ];

        // Determine the season
        $currentSeason = null;
        foreach ($seasons as $season => $dates) {
            $start = Carbon::create($currentDate->year, substr($dates['start'], 0, 2), substr($dates['start'], 3, 2));
            $end = Carbon::create($currentDate->year, substr($dates['end'], 0, 2), substr($dates['end'], 3, 2));

            // Adjust for year boundaries in seasons
            if ($start->greaterThan($end)) {
                $start->subYear();
            }
            if ($currentDate->between($start, $end)) {
                $currentSeason = $season;
                break;
            }
        }
        
        if (!$currentSeason) {
            return ['season' => null, 'price' => null];
        }

        // Fetch the published season
        $publishedSeason = PublishSeason::where('vendor_id', $vendorId)
            ->where('season_type', $currentSeason)
            ->where('publish', 1)
            ->first();

        if (!$publishedSeason) {
            return ['season' => $currentSeason, 'price' => null];
        }

        // Fetch the price from vendor_pricings
        $pricing = VendorPricing::where('vendor_id', $vendorId)->first();

        $price = $pricing ? $pricing->$currentSeason : null;

        // Handle special price if applicable
        if ($pricing && $pricing->special_price && $pricing->special_price_value) {
            $price = $pricing->special_price_value;
        }
        $vendor = Vendor::find($vendorId);
        // check for platform fee
        $platformFee = platformFeeCalculator($vendor, $price);
        if ($platformFee && $vendor->account_status == 1) {
            $price += $platformFee;
        }

        return ['season' => $currentSeason, 'price' => $price];
    }
}
