<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WineryOrderWine extends Model
{
    use HasFactory;

    protected $fillable = [
        'winery_order_id',
        'vendor_wine_id',
        'wine_name',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(WineryOrder::class);
    }
}
