<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WineryCart extends Model
{
    use HasFactory;

    protected $table = 'winery_carts'; // Explicitly set the table name
    protected $fillable = [
        'user_id',
        'status',
        'shop_id',
        'vendor_id',
    ];

    public function items()
    {
        return $this->hasMany(WineryCartItem::class, 'cart_id');
    }
}
