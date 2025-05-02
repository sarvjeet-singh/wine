<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Region;
use App\Models\VendorWine;
use App\Models\VendorWineCategory;

class ShopController extends Controller
{
    public function index()
    {
        // Retrieve the input values
        $search = request('search');
        $subCategoryId = request('sub_category');
        $subRegionId = request('sub_region');

        // Build the query
        $wineries = Vendor::with('sub_category', 'sub_regions', 'reviews', 'mediaGallery')
            ->whereRaw('LOWER(vendor_type) = ?', ['winery'])
            ->where(function ($query) {
                $query->where('account_status', '1')
                    ->orWhere('account_status', '2');
            });


        // Apply filters if input values are provided
        if ($search) {
            $wineries->where('vendor_name', 'LIKE', '%' . $search . '%'); // Assuming 'name' is the column you want to search by
        }

        if ($subCategoryId) {
            $wineries->where('vendor_sub_category', $subCategoryId); // Assuming you have a 'sub_category_id' field in your vendors table
        }

        if ($subRegionId) {
            $wineries->where('sub_region', $subRegionId); // Assuming you have a 'sub_region_id' field in your vendors table
        }

        // Execute the query
        $wineries = $wineries->orderBy('vendor_name', 'asc');
        $region = Region::where('id', 1)->select('name')->first();
        $wineries = $wineries->paginate(10);
        return view('FrontEnd.shop.index', compact('wineries', 'region', 'search', 'subCategoryId', 'region'));
    }

    public function products($shopid)
    {
        $shopActive = Vendor::where('id', $shopid)
            ->where(function ($query) {
                $query->where('account_status', '1')
                    ->orWhere('account_status', '2');
            })
            ->first();
        if (!$shopActive) {
            return redirect()->route('frontend-shop');
        }
        //'wineReviews', 
        $dates = VendorWine::where('vendor_id', $shopid)
            ->select('vintage_date')
            ->distinct()
            ->pluck('vintage_date')
            ->toArray();

        // Get the search and date input from the request
        $search = request()->get('search');
        $date = request()->get('date');
        $varietals = request()->get('varietals'); // This is array

        // Start building the query
        $query = VendorWine::where('vendor_id', $shopid)->where('inventory', '>', 0);

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('series', 'like', '%' . $search . '%');
            });
        }

        // Apply date filter if provided
        if ($date) {
            $query->where('vintage_date', $date);
        }

        // Apply varietals filter if provided
        if (is_array($varietals) && count($varietals) > 0) {
            $query->where(function ($q) use ($varietals) {
                foreach ($varietals as $varietal) {
                    $q->orWhere('grape_varietals', 'like', '%' . $varietal . '%');
                }
            });
        }

        // Fetch the results with ordering
        $wines = $query->orderByRaw('CASE WHEN grape_varietals IS NULL THEN 1 ELSE 0 END, grape_varietals ASC')
            ->where('delisted', 0)
            ->where('retail_price', '>', 0.00)
            ->orderBy('id', 'desc')
            ->paginate(10);
        $vendor = Vendor::where('id', $shopid)->first();
        return view('FrontEnd.shop.products', compact('wines', 'vendor', 'dates', 'search', 'date'));
    }


    public function productDetail($id, $shopid)
    {
        $wineid = $id;
        // Check if the vendor is active
        $vendor = Vendor::where('id', $shopid)
            ->where(function ($query) {
                $query->where('account_status', '1')
                    ->orWhere('account_status', '2');
            })
            ->first();
        if (!$vendor) {
            return redirect()->route('frontend-shop');
        }
        $wine = VendorWine::where('id', $wineid)
            ->where('inventory', '>', 0)
            ->where('delisted', 0)
            ->where('price', '>', 0.00)
            ->first();
        if (!$wine) {
            return redirect()->back();
        }
        $sliders = VendorWine::where('vendor_id', $shopid);
        $grape_varietals = array_filter(array_map('trim', explode(',', $wine->grape_varietals)));
        // Apply varietals filter if provided
        if (is_array($grape_varietals) && count($grape_varietals) > 0) {
            $sliders->where(function ($q) use ($grape_varietals) {
                foreach ($grape_varietals as $varietal) {
                    $q->orWhere('grape_varietals', 'like', '%' . $varietal . '%');
                }
            });
        }
        $sliders = $sliders->where('id', '!=', $wineid)
            ->orderByRaw('CASE WHEN grape_varietals IS NULL THEN 1 ELSE 0 END, grape_varietals ASC')
            ->where('delisted', 0)
            ->where('retail_price', '>', 0.00)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
        return view('FrontEnd.shop.product-detail', compact('wine', 'vendor', 'shopid', 'sliders'));
    }
}
