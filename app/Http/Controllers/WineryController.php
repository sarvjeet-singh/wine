<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Region;
use App\Models\VendorWine;

class WineryController extends Controller
{
    protected $limit;

    public function index($vendorid)
    {
        // Retrieve the input values
        $search = request('search');
        $subCategoryId = request('sub_category');
        $subRegionId = request('sub_region');

        // Build the query
        $wineries = Vendor::with('sub_category', 'sub_regions', 'reviews')
            ->whereRaw('LOWER(vendor_type) = ?', ['winery'])
            ->where(function ($query) {
                $query->where('account_status', '1')
                    ->orWhere('account_status', '2');
            })
            ->where('id', '!=', $vendorid);

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
        return view('VendorDashboard.winery.index', compact('wineries', 'vendorid', 'region', 'search', 'subCategoryId', 'region'));
    }

    public function products($shopid, $vendorid)
    {
        $shopActive = Vendor::where('id', $shopid)
            ->where(function ($query) {
                $query->where('account_status', '1')
                    ->orWhere('account_status', '2');
            })->first();
        if(!$shopActive) {
            return redirect()->route('winery-shop.index', ['vendorid' => $vendorid]);
        }
        //'wineReviews', 
        $dates = VendorWine::where('vendor_id', $shopid)
            ->select('vintage_date')
            ->distinct()
            ->pluck('vintage_date')->toArray();
        // Get the search and date input from the request
        $search = request()->get('search');
        $date = request()->get('date');

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

        // Fetch the results with ordering
        $wines = $query->orderByRaw('CASE WHEN grape_varietals IS NULL THEN 1 ELSE 0 END, grape_varietals ASC')
            ->where('delisted', 0)
            ->where('vendor_id', '!=', $vendorid)
            ->where('price', '>', 0.00)
            ->orderBy('id', 'desc')
            ->paginate(10);
        $vendor = Vendor::where('id', $shopid)->first();
        return view('VendorDashboard.winery.product-listing', compact('wines', 'vendorid', 'shopid', 'vendor', 'dates'));
    }

    public function detail($wineid, $shopid, $vendorid)
    {
        $wine = VendorWine::where('id', $wineid)
            ->where('inventory', '>', 0)
            ->where('vendor_id', '!=', $vendorid)
            ->where('price', '>', 0.00)
            ->first();
        if (!$wine) {
            return redirect()->back();
        }
        $sliders = VendorWine::where('vendor_id', $shopid)
            ->where('id', '!=', $wineid)->limit(5)->get();
        $vendor = Vendor::where('id', $shopid)->first();
        return view('VendorDashboard.winery.product-detail', compact('wine', 'vendor', 'vendorid', 'shopid', 'sliders'));
    }

    public function cart()
    {
        return view('VendorDashboard.winery.cart');
    }

    public function checkout()
    {
        return view('VendorDashboard.winery.checkout');
    }
}
