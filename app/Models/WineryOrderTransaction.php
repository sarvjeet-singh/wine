<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WineryOrderTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'winery_order_id',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'card_brand',
        'card_last4',
        'receipt_url',
        'billing_details',
        'transaction_created_at',
    ];
}
