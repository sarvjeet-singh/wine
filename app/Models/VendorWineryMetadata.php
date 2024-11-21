<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorWineryMetadata extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'tasting_options',
        'farming_practices',
        'max_group',
        'cuisines',
    ];

    public function tastingOptions() {

        return $this->belongsTo(TastingOption::class, 'tasting_options');
    }

    public function farmingPractices()
    {
        return $this->belongsTo(FarmingPractice::class, 'farming_practices');
    }

    public function cuisine()
    {
        return $this->hasMany(Cuisine::class, 'id', 'cuisines');
    }

    public function maxGroup()
    {
        return $this->belongsTo(MaxGroup::class, 'max_group');
    }
}
