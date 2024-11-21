<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorRoom extends Model
{
    use HasFactory;

    // Specify which fields are mass assignable
    protected $fillable = [
        'vendor_id',
        'room_style',
        'room_price',
        'inventory',
        'room_image',
    ];

    /**
     * Get the vendor that owns the room.
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
