<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'vendor_id', 
        'booking_type', 
        'start_date', 
        'end_date',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
