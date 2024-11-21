<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WineryOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendor_buyer_id',
        'vendor_seller_id',
        'subtotal_price',
        'delivery_charges',
        'total_price',
        'status',
        'billing_first_name',
        'billing_last_name',
        'billing_email',
        'billing_phone',
        'billing_street',
        'billing_city',
        'billing_unit',
        'billing_state',
        'billing_postal_code',
        'billing_country',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_email',
        'shipping_phone',
        'shipping_street',
        'shipping_city',
        'shipping_unit',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
        'delivery'
    ];

    public function wines()
    {
        return $this->hasMany(WineryOrderWine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendorBuyer()
    {
        return $this->belongsTo(Vendor::class, 'vendor_buyer_id');
    }

    public function vendorSeller()
    {
        return $this->belongsTo(Vendor::class, 'vendor_seller_id');
    }

    public function transaction()
    {
        return $this->hasOne(WineryOrderTransaction::class);
    }
}
