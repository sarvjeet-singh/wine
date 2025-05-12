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
        'booking_time',
        'description',
        'status',
        'duration',
        'image',
        'thumbnail_small',
        'thumbnail_medium',
        'thumbnail_large',
        'city',
        'state',
        'address',
        'zipcode',
        'quantity',
        'listed_price',
        'genre_id',
        'venue_name',
        'venue_phone',
        'event_rating',
        'is_published',
        'is_featured',
        'price_type',
    ];

    public function category()
    {
        return $this->belongsTo(CurativeExperienceCategory::class);
    }

    public function genre()
    {
        return $this->belongsTo(CurativeExperienceGenre::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
