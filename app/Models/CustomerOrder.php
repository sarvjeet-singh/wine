<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;

    protected $table = 'customer_orders';

    protected $fillable = [
        'customer_id',
        'vendor_id',
        'order_type',
        'sub_total',
        'tax',
        'wallet_amount',
        'total',
        'payment_method',
        'payment_status',
        'order_status',
        'vendor_price',
        'listed_price',
        'platform_fee_percentage',
        'platform_service_fee',
        'vendor_tax',
        'platform_tax',
        'vendor_total',
        'platform_total',
        'vendor_transaction_fee',
        'platform_transaction_fee',
        'vendor_tax_percentage',
        'platform_tax_percentage',
    ];

    public function eventOrderDetail()
    {
        return $this->hasOne(EventOrderDetail::class, 'customer_order_id');
    }

    public function eventGuestDetails()
    {
        return $this->hasMany(EventGuestDetail::class, 'customer_order_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function eventOrderTransactions()
    {
        return $this->hasMany(CustomerOrderTransaction::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
