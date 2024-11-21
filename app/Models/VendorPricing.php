<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'spring',
        'summer',
        'fall',
        'winter',
        'special_price',
        'special_price_value',
        'current_rate',
        'extension'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
