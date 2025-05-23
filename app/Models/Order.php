<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Define the table name (optional if it matches the plural form of the model name)
    protected $table = 'orders';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'name',
        'email',
        'phone',
        'street_address',
        'suite',
        'city',
        'state',
        'country',
        'postal_code',
        'suite',
        'customer_id',
        'vendor_id',
        'check_in_at',
        'check_out_at',
        'nights_count',
        'travel_party_size',
        'visit_purpose',
        'rate_basic',
        'guest_name',
        'guest_email',
        'experiences_selected',
        'experiences_total',
        'cleaning_fee',
        'security_deposit',
        'pet_fee',
        'tax_rate',
        'order_total',
        'inquiry_id',
        'wallet_used',
        'platform_service_fee',
        'platform_service_fee_percentage',
        'cancelled_at',
        'cancel_reason',
        'vendor_cancelled',
        'payment_status',
        'vendor_tax',
        'platform_tax',
        'vendor_total',
        'platform_total',
        'vendor_transaction_fee',
        'platform_transaction_fee',
        'vendor_tax_percentage',
        'platform_tax_percentage',
        'listed_price',
        'vendor_price',
    ];

    // If experiences_selected is stored as JSON, you can cast it to an array
    protected $casts = [
        'experiences_selected' => 'array',
    ];

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }

    public function orderTransactions() {
        return $this->hasMany(OrderTransaction::class);
    }

    // Add any relationships if applicable, for example:
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}