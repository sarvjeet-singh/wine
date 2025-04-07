<?php

namespace App\Helpers;

use App\Models\Customer;
use Carbon\Carbon;

class CustomerHelper
{

    public static function getCustomerProfileCompletionStatus($customerId)
    {
        $messages = [];

        // Fetch the vendor
        $customer = Customer::find($customerId);
        if (!$customer) {
            return ['status' => false, 'messages' => [['message' => 'Customer not found', 'completed' => false]]];
        }

        // Check profile image
        $messages[] = [
            'message' => '<b><a target="_blank" href="'.route('user-settings').'">Profile Image</a></b> (Upload a headshot so Testimonials & Reviews can be made public)',
            'completed' => $customer->profile_image_verified == 'verified' ? true : false
        ];

        // Check social media
        $isSocialMediaComplete = preg_match('/@/', $customer->facebook . $customer->instagram . $customer->youtube . $customer->tiktok . $customer->twitter . $customer->linkedin) ? true : false;
        $messages[] = [
            'message' => '<b><a target="_blank" href="'.route('user.social-media').'">Social Media</a></b> (Let us know what SM platforms you prefer and your handles so we can tag you)',
            'completed' => $isSocialMediaComplete
        ];

        // Check emergency contacts
        $checkEmergencyContacts = !empty($customer->medical_physical_concerns) &&
            !empty($customer->emergency_contact_name) &&
            !empty($customer->emergency_contact_relation) &&
            !empty($customer->emergency_contact_phone_number) &&
            !empty($customer->alternate_contact_full_name) &&
            !empty($customer->alternate_contact_relation) &&
            !empty($customer->emergency_contact_number);
        $messages[] = [
            'message' => '<b><a target="_blank" href="'.route('user.emergency-contact').'">Emergency Contacts</a></b> (Let us know who to contact in case of a mishap on an excursion)',
            'completed' => $checkEmergencyContacts
        ];

        // Check referrals
        $messages[] = [
            'message' => '<b><a target="_blank" href="'.route('user.referrals').'">Referrals</a></b> (Give credit to who motivated you to join our community)',
            'completed' => !empty($customer->guestrewards) ? true : false
        ];

        $checkRegistryDetails = !empty($customer->contact_number) &&
            !empty($customer->city) &&
            !empty($customer->state || $customer->other_state) &&
            !empty($customer->postal_code) &&
            !empty($customer->country || $customer->other_country) &&
            !empty($customer->street_address);
        // Check media gallery
        $messages[] = [
            'message' => '<b><a target="_blank" href="'.route('user-guest-registry').'">Guest Registry</a></b> (Add Guest Registry details for a better guest experience)',
            'completed' => $checkRegistryDetails
        ];

        $checkHomeAddress = !empty($customer->city) &&
            !empty($customer->state || $customer->other_state) &&
            !empty($customer->postal_code) &&
            !empty($customer->country || $customer->other_country) &&
            !empty($customer->street_address);
        // Check media gallery
        $messages[] = [
            'message' => '<b><a target="_blank" href="'.route('user-guest-registry').'">Home Address</a></b> (Your home address is your default delivery location for purchased items)',
            'completed' => $checkHomeAddress
        ];

        $checkGovernmentProof = !empty($customer->government_proof_front) || !empty($customer->government_proof_back);
        // Check media gallery
        $messages[] = [
            'message' => '<b><a target="_blank" href="'.route('user-guest-registry').'#government-information">Government Issue ID</a></b> (Government ID will secure accommodation bookings and self check-in options, when applicable)',
            'completed' => $checkGovernmentProof
        ];

        // Remove duplicate messages while keeping order
        $seenMessages = [];
        $filteredMessages = [];

        foreach ($messages as $item) {
            if (!in_array($item['message'], $seenMessages)) {
                $seenMessages[] = $item['message'];
                $filteredMessages[] = $item;
            }
        }

        $hasErrors = in_array(false, array_column($filteredMessages, 'completed'));
        if (!$hasErrors) {
            $customer->profile_completed = 1;
            $customer->save();
        }

        // Determine status
        $hasErrors = in_array(false, array_column($filteredMessages, 'completed'));

        return [
            'status' => !$hasErrors,
            'messages' => $filteredMessages
        ];
    }
}
