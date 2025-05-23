<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorLicenseMetadata extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'farming_practices',
        'max_group',
        'cuisines',
        'license_number',
        'license_expiry_date',
    ];

    public function cuisine()
    {
        return $this->hasMany(Cuisine::class, 'id', 'cuisines');
    }

    public function farmingPractices()
    {
        return $this->belongsTo(FarmingPractice::class, 'farming_practices');
    }

    public function maxGroup()
    {
        return $this->belongsTo(MaxGroup::class, 'max_group');
    }
}
