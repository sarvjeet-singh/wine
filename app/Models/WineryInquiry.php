<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WineryInquiry extends Model
{
    use HasFactory;

    protected $table = 'winery_inquiries';

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
        'experience_preference',
        'sub_region',
        'winery_types', // This will be stored as JSON
        'additional_comments',
    ];

    /**
     * Cast attributes to native types.
     *
     * @var array
     */
    protected $casts = [
        'visit_nature' => 'array',
        'winery_types' => 'array',
    ];
}
