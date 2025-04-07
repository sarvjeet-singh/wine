<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorWine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'winery_name',
        'region',
        'sub_region',
        'custom_region',
        'custom_sub_region',
        'varietal_blend',
        'vintage_brand_name',
        'vintage_date',
        'bottle_notes',
        'abv',
        'rs',
        'rs_value',
        'bottle_size',
        'sku',
        'image',
        'cellar',
        'cost',
        'commission_delivery_fee',
        'price',
        'inventory',
        'series',
        'description',
        'grape_varietals',
        'pdf',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function reviews()
    {
        return $this->hasMany(WineReview::class);
    }

    public static function updateWineStock($wineryOrderId)
    {
        // Fetch all wines associated with the given winery order ID
        $wineryOrderWines = DB::table('winery_order_wines')
            ->where('winery_order_id', $wineryOrderId)
            ->get();

        foreach ($wineryOrderWines as $orderWine) {
            // Find the corresponding VendorWine record
            $vendorWine = self::find($orderWine->vendor_wine_id);

            if ($vendorWine) {
                // Update the inventory by reducing the quantity ordered
                $vendorWine->inventory -= $orderWine->quantity;
                $vendorWine->save();
            }
        }
    }

    public function regions()
    {
        return $this->hasOne(Region::class, 'id', 'region');
    }

    public function subRegions()
    {
        return $this->hasOne(SubRegion::class, 'id', 'sub_region');
    }
}
