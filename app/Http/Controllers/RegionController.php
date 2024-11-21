<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubRegion; // Adjust model as needed

class RegionController extends Controller
{
    public function getSubRegions($regionId)
    {
        $subRegions = SubRegion::where('region_id', $regionId)->get(['id', 'name']);
        return response()->json($subRegions);
    }
}

