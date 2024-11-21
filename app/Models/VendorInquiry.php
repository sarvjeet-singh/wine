<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorInquiry extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'user_id',
        'check_in',
        'check_out',
        'visit_nature',
        'guest_no',
        'vendor_sub_category',
        'sub_region',
        'rooms_required',
        'excursion_activities',
        'preferred_accommodation',
        'group_type',
        'additional_comments_inquiry',
    ];
}
