<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WineReview extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'vendor_wine_id', 'rating', 'review_description', 'vendor_id', 'review_status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(VendorWine::class);
    }
}
