<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorSocialMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'linkedin',
        'tiktok'
    ];
}
