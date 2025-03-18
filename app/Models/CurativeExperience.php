<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurativeExperience extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'category_id',
        'name',
        'admittance',
        'is_free',
        'extension',
        'booking_url',
        'inventory',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'description',
        'status',
        'duration',
        'image',
        'thumbnail_small',
        'thumbnail_medium',
        'thumbnail_large'
    ];

    public function category()
    {
        return $this->belongsTo(CurativeExperienceCategory::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
