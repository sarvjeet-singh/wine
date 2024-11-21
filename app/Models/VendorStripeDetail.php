<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorStripeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'stripe_account_id',
        'stripe_publishable_key',
        'stripe_secret_key',
        'webhook_secret_key',
    ];
}
