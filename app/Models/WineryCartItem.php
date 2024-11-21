<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WineryCartItem extends Model
{
    use HasFactory;
    protected $table = 'winery_cart_items'; // Explicitly set the table name
    protected $fillable = ['cart_id', 'vendor_wine_id', 'quantity'];

    public function cart()
    {
        return $this->belongsTo(WineryCart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(VendorWine::class, 'vendor_wine_id');
    }
}
