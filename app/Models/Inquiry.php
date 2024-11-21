<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

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
        'inquiry_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
