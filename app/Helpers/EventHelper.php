<?php

namespace App\Helpers;

use App\Models\PublishSeason;
use App\Models\VendorPricing;
use Carbon\Carbon;

class EventHelper
{
    public static function listingPrice($eventPrice, $vendorPlatformFee, $globalPlatformFee) {
        if($vendorPlatformFee > 0) {
            // in percentage
            return number_format($eventPrice + ($eventPrice * ($vendorPlatformFee / 100)), 2, '.', '');
        } else if($globalPlatformFee > 0) {
            // in percentage
            return number_format($eventPrice + ($eventPrice * ($globalPlatformFee / 100)), 2, '.', '');
        } else {
            return $eventPrice;
        }
    }
}