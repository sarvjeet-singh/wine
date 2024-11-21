<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendor_id',
        'title',
        'upgradefee',
        'currenttype',
        'description',
        'status',
    ];

    /**
     * Get the user that owns the experience.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the vendor that owns the experience.
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
