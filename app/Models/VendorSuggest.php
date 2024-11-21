<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorSuggest extends Model
{
    use HasFactory;

    protected $table = 'vendor_suggest';

    protected $fillable = [
        'user_id',
        'vendor_name',
        'street_address',
        'unit_suite',
        'city_town',
        'province_state',
        'postal_zip',
        'vendor_phone',
    ];
}