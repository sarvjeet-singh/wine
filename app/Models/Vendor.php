<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vendor_name',
        'user_id',
        'vendor_email',
        'street_address',
        'unitsuite',
        'hide_street_address',
        'city',
        'province',
        'postalCode',
        'country',
        'vendor_phone',
        'description',
        'vendor_sub_category',
        'region',
        'sub_region',
        'discount',
        'vendor_slug',
        'account_status',
        'vendor_type',
        'checkin_start_time',
        'checkin_end_time',
        'checkout_time',
        'inventory_type',
        'vendor_media_logo',
        'website',
        'price_point',
        'vendor_stripe_id',
        'password_updated',
        'host',
    ];
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->vendor_slug = Str::slug($model->vendor_name);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function socialMedia()
    {
        return $this->hasOne(VendorSocialMedia::class);
    }
    public function pricing()
    {
        return $this->hasOne(VendorPricing::class);
    }
    public function mediaGallery()
    {
        return $this->hasMany(VendorMediaGallery::class);
    }
    public function bookingDates()
    {
        return $this->hasMany(BookingDate::class);
    }
    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class)->where('review_status', 'approved');
    }
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'vendor_amenities')
            ->withPivot('status')
            ->wherePivot('status', 'active');  // Filter for 'active' status
    }
    public function vendorRooms()
    {
        return $this->hasMany(VendorRoom::class, 'vendor_id', 'id');
    }

    public function businessHours()
    {
        return $this->hasMany(BusinessHour::class, 'vendor_id');
    }

    public function accommodationMetadata()
    {
        return $this->hasOne(VendorAccommodationMetadata::class, 'vendor_id');
    }

    public function excursionMetadata()
    {
        return $this->hasOne(VendorExcursionMetadata::class, 'vendor_id');
    }

    public function wineryMetadata()
    {
        return $this->hasOne(VendorWineryMetadata::class, 'vendor_id');
    }

    public function licenseMetadata()
    {
        return $this->hasOne(VendorLicenseMetadata::class, 'vendor_id');
    }

    public function nonLicenseMetadata()
    {
        return $this->hasOne(VendorNonLicenseMetadata::class, 'vendor_id');
    }

    public function countryName() {
        return $this->belongsTo(Country::class, 'country');
    }

    public function sub_category() {
        return $this->belongsTo(SubCategory::class, 'vendor_sub_category');
    }

    public function sub_regions() {
        return $this->belongsTo(SubRegion::class, 'sub_region');
    }

    public function pricePoint() {
        return $this->belongsTo(PricePoint::class, 'price_point');
    }
}