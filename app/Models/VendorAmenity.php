<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorAmenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'amenity_id',
        'status',
        'public_amenities',
    ];
    // Cast the public_amenities attribute to an array
    protected $casts = [
        'public_amenities' => 'array',
    ]; 
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function amenity()
    {
        return $this->belongsTo(Amenity::class);
    }
}
