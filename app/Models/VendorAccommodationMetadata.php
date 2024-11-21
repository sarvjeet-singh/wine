<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorAccommodationMetadata extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'checkin_start_time',
        'checkin_end_time',
        'checkout_time',
        'square_footage',
        'bedrooms',
        'washrooms',
        'sleeps',
        'booking_minimum',
        'booking_maximum',
        'security_deposit_amount',
        'applicable_taxes_amount',
        'cleaning_fee_amount',
        'beds',
        'pet_boarding',
    ];
}
