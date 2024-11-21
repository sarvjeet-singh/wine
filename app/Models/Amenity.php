<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;
    protected $fillable = [
        'amenity_name',
        'amenity_type',
        'amenity_status',
        'amenity_icons',
    ];
    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_amenities')->withPivot('status');
    }
}
