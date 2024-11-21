<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorHour extends Model
{
    protected $fillable = ['vendor_id', 'day', 'open_time', 'close_time'];
}