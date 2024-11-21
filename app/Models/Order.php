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
        'user_id',
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