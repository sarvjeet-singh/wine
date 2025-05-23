<?php

namespace App\Helpers;

use App\Models\PublishSeason;
use App\Models\Vendor;
use App\Models\VendorAccommodationMetadata;
use App\Models\VendorWineryMetadata;
use App\Models\VendorExcursionMetadata;
use App\Models\VendorMediaGallery;
use App\Models\WinerySubscription;
use App\Models\VendorPricing;
use App\Models\BusinessHour;
use App\Models\VendorAmenity;
use App\Models\VendorWine;
use Carbon\Carbon;

class VendorHelper
{
    public static function canActivateSubscription($vendorId)
    {
        $messages = [];

        // Fetch the vendor
        $vendor = Vendor::find($vendorId);
        if (!$vendor) {
            return ['status' => false, 'messages' => [['message' => 'Vendor not found', 'completed' => false]]];
        }

        // Check subscription status
        // Check subscription status
        // $subscription = WinerySubscription::where('vendor_id', $vendorId)
        //     ->where('status', 'active')
        //     ->where('end_date', '>', Carbon::now())
        //     ->exists();


        // $messages[] = [
        //     'message' => '<b><a target="_blank" href="' . route('subscription.index',$vendorId) . '">Subscription Status</b> (Make sure your subscription is active to stay visible on the platform.)',
        //     'completed' => !$subscription ? false : true,
        //     'is_optional' => false
        // ];

        // Check vendor details completeness
        $requiredVendorFields = [
            'vendor_name',
            'vendor_email',
            'vendor_phone',
            'street_address',
            'city',
            'province',
            'postalCode',
            'country',
            'vendor_sub_category',
            'region',
            'sub_region',
            'short_code',
            'qr_code',
            'inventory_type'
        ];
        $isVendorComplete = true;
        foreach ($requiredVendorFields as $field) {
            if (empty($vendor->$field)) {
                $isVendorComplete = false;
                break;
            }
        }
        
        $messages[] = [
            'message' => '<b><a target="_blank" href="' . route('vendor-settings',$vendorId) . '">Vendor Account Details</a></b> (Please ensure basic contact details are correct or updated)',
            'completed' => $isVendorComplete,
            'is_optional' => false
        ];
        

        // Media Gallery
        $mediaCount = VendorMediaGallery::where('vendor_id', $vendorId)->count();
        $messages[] = [
            'message' => '<b><a target="_blank" href="' . route('vendor-media-gallary',$vendorId) . '">Media Gallery</a></b> (Please upload images or links to YouTube videos to help promote experiences)',
            'completed' => $mediaCount > 4,
            'is_optional' => false
        ];

        // Refund Policy
        $messages[] = [
            'message' => '<b><a target="_blank" href="' . route('vendor-booking-utility',$vendorId) . '">Refund Policy</a></b> (Please set the policy most applicable to your transactions)',
            'completed' => !empty($vendor->policy),
            'is_optional' => false
        ];

        // Stripe Account
        $isStripeConnected = !empty($vendor->stripe_account_id) && $vendor->stripe_onboarding_account_status === 'active';
        $messages[] = [
            'message' => '<b><a target="_blank" href="' . route('stripe.details.show',$vendorId) . '">Stripe Account</a></b> (Please integrate a Stripe payment gateway account for seamless payments)',
            'completed' => $isStripeConnected,
            'is_optional' => false
        ];

        // Amenities (Optional)
        // $vendorAmenities = VendorAmenity::where('vendor_id', $vendorId)->exists();
        // $messages[] = [
        //     'message' => '<b><a target="_blank" href="' . route('vendor-amenities',$vendorId) . '">Amenities</a></b> (Please indicate any amenities applicable to your establishment)',
        //     'completed' => $vendorAmenities,
        //     'is_optional' => true
        // ];

        $publishSeason = PublishSeason::where('vendor_id', $vendorId)->count();
        $messages[] = [
            'message' => '<b><a target="_blank" href="' . route('inventory-management',$vendorId) . '">Inventory</a></b> (Please set the inventory for your accommodations)',
            'completed' => $publishSeason > 0 ? true : false,
            'is_optional' => false
        ];

        $pricing = VendorPricing::where('vendor_id', $vendorId)->first();
        $pricingError = true;
        if (!$pricing) {
            $pricingError = false;
        } else {
            if (empty($pricing->spring)) {
                $pricingError = false;
            }
            if (empty($pricing->summer)) {
                $pricingError = false;
            }
            if (empty($pricing->fall)) {
                $pricingError = false;
            }
            if (empty($pricing->winter)) {
                $pricingError = false;
            }
            if ($pricing->special_price == 1 && empty($pricing->special_price_value)) {
                $pricingError = false;
            }
        }
        
        $messages[] = [
            'message' => '<b><a target="_blank" href="' . route('vendor-pricing',$vendorId) . '">Pricing</a></b> (Please set the pricing for your accommodations)',
            'completed' => $pricingError,
            'is_optional' => false
        ];

        if ($isVendorComplete) {
            $vendorWineryMetadata = VendorAccommodationMetadata::where('vendor_id', $vendorId)->first();
            $requiredVendorMetadataFields = [
                'applicable_taxes_amount',
                'checkin_start_time',
                'checkout_time',
                'booking_minimum',
                'booking_maximum',
                'process_type',
            ];
            $isVendorComplete = true;
            foreach ($requiredVendorMetadataFields as $field) {
                if (empty($vendorWineryMetadata->$field)) {
                    $isVendorComplete = false;
                    break;
                }
            }
            $messages[] = [
                'message' => '<b><a target="_blank" href="' . route('vendor-booking-utility',$vendorId) . '">Transaction parameter</a></b> (Please set the transaction parameters for your accommodations)',
                'completed' => $isVendorComplete,
                'is_optional' => false
            ];
        }

        // Remove duplicates while keeping the exact order
        $seenMessages = [];
        $filteredMessages = [];
        foreach ($messages as $item) {
            if (!in_array($item['message'], $seenMessages)) {
                $seenMessages[] = $item['message'];
                $filteredMessages[] = $item;
            }
        }

        // Determine status (IGNORE "optional" fields when checking errors)
        $hasErrors = false;
        foreach ($filteredMessages as $msg) {
            if (!$msg['completed'] && !$msg['is_optional']) {
                $hasErrors = true;
                break;
            }
        }

        // Activate vendor if all required fields are complete
        if (!$hasErrors) {
            $vendor->account_status = 1;
            $vendor->save();
        }

        return [
            'status' => !$hasErrors,
            'messages' => $filteredMessages
        ];
    }


    /**
     * Check if the vendor can activate bookings
     */
    public static function canActivateBooking($vendorId)
    {
        $errors = [];

        // Fetch the vendor
        $vendor = Vendor::find($vendorId);
        if (!$vendor) {
            return ['status' => false, 'messages' => ['Vendor not found']];
        }

        // Helper function to format field names
        $formatFieldName = function ($field) {
            return ucfirst(str_replace('_', ' ', $field));
        };

        // Check if pricing details are provided
        $pricing = VendorPricing::where('vendor_id', $vendorId)->first();
        $missingPricingFields = [];

        if (!$pricing) {
            $errors[] = "Pricing details are missing";
        } else {
            if (empty($pricing->spring)) $missingPricingFields[] = 'Spring';
            if (empty($pricing->summer)) $missingPricingFields[] = 'Summer';
            if (empty($pricing->fall)) $missingPricingFields[] = 'Fall';
            if (empty($pricing->winter)) $missingPricingFields[] = 'Winter';
            if ($pricing->special_price == 1 && empty($pricing->special_price_value)) {
                $missingPricingFields[] = 'Special Price Value';
            }
            if (!empty($missingPricingFields)) {
                $errors[] = "Missing pricing details: " . implode(', ', $missingPricingFields);
            }
        }

        // Check if the vendor has integrated a payment gateway
        if (empty($vendor->stripe_account_id) || $vendor->stripe_onboarding_account_status !== 'active') {
            $errors[] = "Payment gateway integration is incomplete";
        }

        // Return result
        if (!empty($errors)) {
            return ['status' => false, 'messages' => $errors];
        }

        return ['status' => true, 'messages' => ['Vendor is eligible to activate bookings']];
    }

    public static function canActivateWinerySubscription($vendorId)
    {
        $messages = [];

        // Fetch the vendor
        $vendor = Vendor::find($vendorId);
        if (!$vendor) {
            return ['status' => false, 'messages' => [['message' => 'Vendor not found', 'completed' => false, 'is_optional' => false]]];
        }

        // Check subscription status
        // $subscription = WinerySubscription::where('vendor_id', $vendorId)
        //     ->where('status', 'active')
        //     ->where('end_date', '>', Carbon::now())
        //     ->exists();


        // $messages[] = [
        //     'message' => '<b><a target="_blank" href="' . route('subscription.index',$vendorId) . '">Subscription Status</b> (Make sure your subscription is active to stay visible on the platform.)',
        //     'completed' => !$subscription ? false : true,
        //     'is_optional' => false
        // ];
        // return ['status' => false, 'messages' => [['message' => 'No active subscription on your account. Please activate your subscription.', 'completed' => false, 'is_optional' => false]]];


        // Required Fields
        $requiredVendorFields = [
            'vendor_name',
            'vendor_email',
            'vendor_phone',
            'street_address',
            'city',
            'province',
            'postalCode',
            'country',
            'vendor_sub_category',
            'region',
            'sub_region',
            'short_code',
            'qr_code',
            'description',
        ];
        $isVendorComplete = true;
        foreach ($requiredVendorFields as $field) {
            if (empty($vendor->$field)) {
                $isVendorComplete = false;
                break;
            }
        }
        if (!$isVendorComplete) {
            $messages[] = [
                'message' => '<b><a target="_blank" href="' . route('vendor-settings',$vendorId) . '">Vendor Account Details</a></b> (Please ensure basic contact details are correct or updated)',
                'completed' => $isVendorComplete,
                'is_optional' => false
            ];
        }
        if ($isVendorComplete) {
            $vendorWineryMetadata = VendorWineryMetadata::where('vendor_id', $vendorId)->first();
            $requiredVendorMetadataFields = [
                'applicable_taxes_amount',
                'applicable_vendor_taxes_amount',
            ];
            $isVendorComplete = true;
            foreach ($requiredVendorMetadataFields as $field) {
                if (empty($vendorWineryMetadata->$field)) {
                    $isVendorComplete = false;
                    break;
                }
            }
            $messages[] = [
                'message' => '<b><a target="_blank" href="' . route('vendor-booking-utility',$vendorId) . '">Vendor Account Details</a></b> (Please ensure basic contact details are correct or updated)',
                'completed' => $isVendorComplete,
                'is_optional' => false
            ];
        }

        // Wine Catalogue
        $wines = VendorWine::where('vendor_id', $vendorId)->exists();
        $messages[] = [
            'message' => '<b><a target="_blank" href="' . route('vendor-wines.index',$vendorId) . '">Wine Catalogue</a></b> (Please input as many wines as you would like to make available to resellers)',
            'completed' => $wines,
            'is_optional' => false
        ];

        // Media Gallery
        $mediaCount = VendorMediaGallery::where('vendor_id', $vendorId)->count();
        $messages[] = [
            'message' => '<b><a target="_blank" href="' . route('vendor-media-gallary',$vendorId) . '">Media Gallery</a></b> (Please upload images or links to YouTube videos to help promote experiences)',
            'completed' => $mediaCount > 4,
            'is_optional' => false
        ];

        // Refund Policy
        $messages[] = [
            'message' => '<b><a target="_blank" href="' . route('vendor-booking-utility',$vendorId) . '">Refund Policy</a></b> (Please set the policy most applicable to your transactions)',
            'completed' => !empty($vendor->policy),
            'is_optional' => false
        ];

        // Stripe Account
        $isStripeConnected = !empty($vendor->stripe_account_id) && $vendor->stripe_onboarding_account_status === 'active';
        $messages[] = [
            'message' => '<b><a target="_blank" href="' . route('stripe.details.show',$vendorId) . '">Stripe Account</a></b> (Please integrate a Stripe payment gateway account for seamless payments)',
            'completed' => $isStripeConnected,
            'is_optional' => false
        ];

        // Business Hours (Optional)
        $businessHours = BusinessHour::where('vendor_id', $vendorId)->exists();
        $messages[] = [
            'message' => '<b><a target="_blank" href="' . route('business-hours.index',$vendorId) . '">Business Hours</a></b> (Please update applicable business hours so users know when you are open)',
            'completed' => $businessHours,
            'is_optional' => true
        ];

        // Amenities (Optional)
        $vendorAmenities = VendorAmenity::where('vendor_id', $vendorId)->exists();
        $messages[] = [
            'message' => '<b><a target="_blank" href="' . route('vendor-amenities',$vendorId) . '">Amenities</a></b> (Please indicate any amenities applicable to your establishment)',
            'completed' => $vendorAmenities,
            'is_optional' => true
        ];

        // Remove duplicates while keeping the exact order
        $seenMessages = [];
        $filteredMessages = [];
        foreach ($messages as $item) {
            if (!in_array($item['message'], $seenMessages)) {
                $seenMessages[] = $item['message'];
                $filteredMessages[] = $item;
            }
        }

        // Determine status (IGNORE "optional" fields when checking errors)
        $hasErrors = false;
        foreach ($filteredMessages as $msg) {
            if (!$msg['completed'] && !$msg['is_optional']) {
                $hasErrors = true;
                break;
            }
        }

        // Activate vendor if all required fields are complete
        if (!$hasErrors) {
            $vendor->account_status = 1;
            $vendor->save();
        }

        return [
            'status' => !$hasErrors,
            'messages' => $filteredMessages
        ];
    }

    public static function canActivateExcursionSubscription($vendorId)
    {
        $messages = [];

        // Fetch the vendor
        $vendor = Vendor::find($vendorId);
        if (!$vendor) {
            return ['status' => false, 'messages' => [['message' => 'Vendor not found', 'completed' => false]]];
        }

        // Check subscription status
        // $subscription = WinerySubscription::where('vendor_id', $vendorId)
        //     ->where('status', 'active')
        //     ->where('end_date', '>', Carbon::now())
        //     ->exists();
        // if (!$subscription) {
        //     return ['status' => false, 'messages' => [['message' => 'No active subscription on your account. Please activate your subscription.', 'completed' => false]]];
        // }

        // Check vendor details
        $requiredVendorFields = [
            'vendor_name',
            'vendor_email',
            'vendor_phone',
            'street_address',
            'city',
            'province',
            'postalCode',
            'country',
            'vendor_sub_category',
            'region',
            'sub_region',
            'short_code',
            'qr_code'
        ];
        $isVendorComplete = true;
        foreach ($requiredVendorFields as $field) {
            if (empty($vendor->$field)) {
                $isVendorComplete = false;
                break;
            }
        }
        $messages[] = [
            'message' => '<b>Excursion Details</b> (All details provided)',
            'completed' => $isVendorComplete
        ];

        // Check vendor excursion metadata
        $metadata = VendorExcursionMetadata::where('vendor_id', $vendorId)->first();
        $isMetadataComplete = $metadata && !empty($metadata->applicable_taxes_amount);
        $messages[] = [
            'message' => '<b>Excursion Details</b> (All details provided)',
            'completed' => $isMetadataComplete
        ];

        // Check refund policy
        $messages[] = [
            'message' => '<b>Refund Policy</b> (Refund policy set)',
            'completed' => !empty($vendor->policy)
        ];

        // Check payment integration
        $isStripeConnected = !empty($vendor->stripe_account_id) && $vendor->stripe_onboarding_account_status === 'active';
        $messages[] = [
            'message' => '<b>Stripe Account</b> Integration (Connect your Stripe account for seamless payments)',
            'completed' => $isStripeConnected
        ];

        // Check media gallery
        $mediaCount = VendorMediaGallery::where('vendor_id', $vendorId)->count();
        $messages[] = [
            'message' => '<b>Media Gallery</b> (Images uploaded)',
            'completed' => $mediaCount > 0
        ];

        // Check business hours
        $businessHours = BusinessHour::where('vendor_id', $vendorId)->exists();
        $messages[] = [
            'message' => '<b>Business Hours</b> (Business hours set)',
            'completed' => $businessHours
        ];

        // Remove duplicates while keeping the exact order
        $seenMessages = [];
        $filteredMessages = [];
        foreach ($messages as $item) {
            if (!in_array($item['message'], $seenMessages)) {
                $seenMessages[] = $item['message'];
                $filteredMessages[] = $item;
            }
        }

        // Determine status
        $hasErrors = in_array(false, array_column($filteredMessages, 'completed'));
        if (!$hasErrors) {
            $vendor->account_status = 1;
            $vendor->save();
        }

        return [
            'status' => !$hasErrors,
            'messages' => $filteredMessages
        ];
    }
}
