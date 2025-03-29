<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinerySubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'stripe_subscription_id',
        'stripe_price_id',
        'price',
        'status',
        'start_date',
        'end_date',
        'subscription_notes',
        'price_type',
        'charge_amount',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
