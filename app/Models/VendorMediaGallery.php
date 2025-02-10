<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorMediaGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'vendor_media', 
        'vendor_media_type', 
        'is_default', 
    ];
}
