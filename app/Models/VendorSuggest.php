<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorSuggest extends Model
{
    use HasFactory;

    protected $table = 'vendor_suggest';

    protected $fillable = [
        'full_name',
        'user_city',
        'user_state',
        'user_email',
        'user_phone',
        'relationship',
        'country',
        'user_id',
        'vendor_name',
        'street_address',
        'unit_suite',
        'city_town',
        'province_state',
        'postal_zip',
        'vendor_phone',
        'vendor_category',
        'vendor_sub_category',
        'establishment_facility',
    ];
}