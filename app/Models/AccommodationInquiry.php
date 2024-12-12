<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationInquiry extends Model
{
    use HasFactory;

    protected $table = 'accommodation_inquiries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'vendor_id',
        'check_in_date',
        'check_out_date',
        'visit_nature', // This will be stored as JSON
        'number_of_guests',
        'accommodation_type', // This will be stored as JSON
        'city',
        'rooms_or_beds',
        'additional_comments',
    ];

    /**
     * Cast attributes to native types.
     *
     * @var array
     */
    protected $casts = [
        'visit_nature' => 'array',
        'accommodation_type' => 'array',
    ];
}