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
use Carbon\Carbon;

class VendorHelper
{
    public static function canActivateSubscription($vendorId)
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

        // Required fields in `vendors` table
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
            'inventory_type',
        ];
        $missingVendorFields = [];
        foreach ($requiredVendorFields as $field) {
            if (empty($vendor->$field)) {
                $missingVendorFields[] = $formatFieldName($field);
            }
        }
        if (!empty($missingVendorFields)) {
            $errors[] = "Missing vendor fields: " . implode(', ', $missingVendorFields);
        }

        // Check vendor accommodation metadata completeness
        $metadata = VendorAccommodationMetadata::where('vendor_id', $vendorId)->first();
        if (!$metadata) {
            $errors[] = "Vendor accommodation details not complete";
        } else {
            $requiredVendorMetaFields = [
                'checkin_start_time',
                'checkout_time',
                'square_footage',
                'bedrooms',
                'washrooms',
                'sleeps',
                'booking_minimum',
                'booking_maximum',
                'applicable_taxes_amount',
                'beds'
            ];
            $missingMetadataFields = [];
            foreach ($requiredVendorMetaFields as $field) {
                if (empty($metadata->$field)) {
                    $missingMetadataFields[] = $formatFieldName($field);
                }
            }
            if (!empty($missingMetadataFields)) {
                $errors[] = "Missing vendor accommodation fields: " . implode(', ', $missingMetadataFields);
            }
        }

        // Check vendor refund policy completeness
        if (empty($vendor->policy)) {
            $errors[] = "Missing Vendor Refund Policy";
        }

        // Check if pricing details are provided and complete
        // $pricing = VendorPricing::where('vendor_id', $vendorId)->first();
        // $missingPricingFields = [];
        // if (!$pricing) {
        //     $errors[] = "Pricing details are missing";
        // } else {
        //     if (empty($pricing->spring)) $missingPricingFields[] = 'Spring';
        //     if (empty($pricing->summer)) $missingPricingFields[] = 'Summer';
        //     if (empty($pricing->fall)) $missingPricingFields[] = 'Fall';
        //     if (empty($pricing->winter)) $missingPricingFields[] = 'Winter';
        //     if ($pricing->special_price == 1 && empty($pricing->special_price_value)) {
        //         $missingPricingFields[] = 'Special Price Value';
        //     }
        //     if (!empty($missingPricingFields)) {
        //         $errors[] = "Missing pricing details: " . implode(', ', $missingPricingFields);
        //     }
        // }

        // Check if the vendor has integrated a payment gateway
        if (empty($vendor->stripe_account_id) || $vendor->stripe_onboarding_account_status != 'active') {
            $errors[] = "Payment gateway integration is incomplete";
        }

        // Check if published seasons are present
        // $seasons = PublishSeason::where('vendor_id', $vendorId)->count();
        // if ($seasons == 0) {
        //     $errors[] = "Publish season is missing";
        // }

        // Check for vendor media gallery completeness
        $media = VendorMediaGallery::where('vendor_id', $vendorId)->count();
        if ($media == 0) {
            $errors[] = "Vendor media gallery is missing";
        }

        $subscription = WinerySubscription::where('vendor_id', $vendorId)
        ->where('status', 'active')
        ->where('end_date', '>', Carbon::now())
        ->first();

        if (!$subscription) {
            $errors[] = "Vendor has no active subscription";
        }
        

        // Return result
        if (!empty($errors)) {
            return ['status' => false, 'messages' => $errors];
        }

        if(empty($errors)) {
            $vendor->update('account_status', 1);
        }

        return ['status' => true, 'messages' => ['Vendor is eligible for activation']];
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

        // Required fields in `vendors` table
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
            'inventory_type',
        ];
        $missingVendorFields = [];
        foreach ($requiredVendorFields as $field) {
            if (empty($vendor->$field)) {
                $missingVendorFields[] = $formatFieldName($field);
            }
        }
        if (!empty($missingVendorFields)) {
            $errors[] = "Missing vendor fields: " . implode(', ', $missingVendorFields);
        }

        // Check vendor winery metadata completeness
        $metadata = VendorWineryMetadata::where('vendor_id', $vendorId)->first();
        if (!$metadata) {
            $errors[] = "Vendor winery details not complete";
        } else {
            $requiredVendorMetaFields = [
                'applicable_taxes_amount',
            ];
            $missingMetadataFields = [];
            foreach ($requiredVendorMetaFields as $field) {
                if (empty($metadata->$field)) {
                    $missingMetadataFields[] = $formatFieldName($field);
                }
            }
            if (!empty($missingMetadataFields)) {
                $errors[] = "Missing vendor winery fields: " . implode(', ', $missingMetadataFields);
            }
        }

        // Check vendor refund policy completeness
        if (empty($vendor->policy)) {
            $errors[] = "Missing Vendor Refund Policy";
        }

        // Check if the vendor has integrated a payment gateway
        if (empty($vendor->stripe_account_id) || $vendor->stripe_onboarding_account_status != 'active') {
            $errors[] = "Payment gateway integration is incomplete";
        }

        // Check for vendor media gallery completeness
        $media = VendorMediaGallery::where('vendor_id', $vendorId)->count();
        if ($media == 0) {
            $errors[] = "Vendor media gallery is missing";
        }

        $subscription = WinerySubscription::where('vendor_id', $vendorId)
        ->where('status', 'active')
        ->where('end_date', '>', Carbon::now())
        ->first();

        if (!$subscription) {
            $errors[] = "Vendor has no active subscription";
        }
        

        // Return result
        if (!empty($errors)) {
            return ['status' => false, 'messages' => $errors];
        }

        if(empty($errors)) {
            $vendor->update('account_status', 1);
        }

        return ['status' => true, 'messages' => ['Vendor is eligible for activation']];
    }
    public static function canActivateExcursionSubscription($vendorId)
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

        // Required fields in `vendors` table
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
            'inventory_type',
        ];
        $missingVendorFields = [];
        foreach ($requiredVendorFields as $field) {
            if (empty($vendor->$field)) {
                $missingVendorFields[] = $formatFieldName($field);
            }
        }
        if (!empty($missingVendorFields)) {
            $errors[] = "Missing vendor fields: " . implode(', ', $missingVendorFields);
        }

        // Check vendor excursion metadata completeness
        $metadata = VendorExcursionMetadata::where('vendor_id', $vendorId)->first();
        if (!$metadata) {
            $errors[] = "Vendor excursion details not complete";
        } else {
            $requiredVendorMetaFields = [
                'applicable_taxes_amount',
            ];
            $missingMetadataFields = [];
            foreach ($requiredVendorMetaFields as $field) {
                if (empty($metadata->$field)) {
                    $missingMetadataFields[] = $formatFieldName($field);
                }
            }
            if (!empty($missingMetadataFields)) {
                $errors[] = "Missing vendor excursion fields: " . implode(', ', $missingMetadataFields);
            }
        }

        // Check vendor refund policy completeness
        if (empty($vendor->policy)) {
            $errors[] = "Missing Vendor Refund Policy";
        }

        // Check if the vendor has integrated a payment gateway
        if (empty($vendor->stripe_account_id) || $vendor->stripe_onboarding_account_status != 'active') {
            $errors[] = "Payment gateway integration is incomplete";
        }

        // Check for vendor media gallery completeness
        $media = VendorMediaGallery::where('vendor_id', $vendorId)->count();
        if ($media == 0) {
            $errors[] = "Vendor media gallery is missing";
        }

        $subscription = WinerySubscription::where('vendor_id', $vendorId)
        ->where('status', 'active')
        ->where('end_date', '>', Carbon::now())
        ->first();

        if (!$subscription) {
            $errors[] = "Vendor has no active subscription";
        }
        

        // Return result
        if (!empty($errors)) {
            return ['status' => false, 'messages' => $errors];
        }

        if(empty($errors)) {
            $vendor->update('account_status', 1);
        }

        return ['status' => true, 'messages' => ['Vendor is eligible for activation']];
    }
}
