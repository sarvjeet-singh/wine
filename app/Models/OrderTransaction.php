<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_type',
        'amount',
        'transaction_id',
        'transaction_status',
        'transaction_amount',
        'transaction_currency',
        'transaction_created_at',
        'card_brand_name',
        'cc_number',
        'expiry',
    ];

    // Accessor to convert the Unix timestamp to Y-m-d H:i:s format
    public function getTransactionCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::createFromTimestamp($value)->format('Y-m-d H:i:s');
    }

    // Mutator to ensure Unix timestamp is saved correctly
    public function setTransactionCreatedAtAttribute($value)
    {
        $this->attributes['transaction_created_at'] = \Carbon\Carbon::parse($value)->timestamp;
    }

    // If you have a relation to the Order model
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
