<?php

namespace App\Http\Controllers;

use App\Models\VendorWine;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorWineController extends Controller
{
    // Define a common array for varietal type mappings
    private $varietalNames = [
        1 => 'Varietal',
        2 => 'Riesling',
        3 => 'Chardonnay',
        4 => 'Gewürztraminer',
        5 => 'Merlot',
        6 => 'Gamay Noir',
        7 => 'Pinot Noir',
        8 => 'Cabernet Franc',
        9 => 'Cabernet Sauvignon',
    ];

    /**
     * Convert varietal type IDs to comma-separated names.
     */
    private function getVarietalNames(array $varietalTypes): string
    {
        return implode(', ', array_map(
            fn($type) => $this->varietalNames[$type] ?? '',
            $varietalTypes
        ));
    }
    public function index($vendor_id)
    {
        $wines = VendorWine::where('vendor_id', $vendor_id)
            ->orderBy('id', 'desc')
            ->get();
        return view('VendorDashboard.vendor-wines.vendor-wines', compact('wines', 'vendor_id'));
    }

    public function add($vendor_id)
    {
        $vendor = Vendor::find($vendor_id);
        return view('VendorDashboard.vendor-wines.add', compact('vendor_id', 'vendor'));
    }

    public function edit($id, $vendor_id)
    {
        $vendor = Vendor::find($vendor_id);
        $wine = VendorWine::find($id);
        return view('VendorDashboard.vendor-wines.edit', compact('wine', 'vendor_id', 'vendor'));
    }

    public function store(Request $request, $vendor_id)
    {
        $request->validate([
            // 'winery_name' => 'required|string|min:2',
            'region' => 'nullable|string',
            'sub_region' => 'nullable|string',
            'custom_region' => 'nullable|string',
            'custom_sub_region' => 'nullable|string',
            'varietal_blend.*' => 'nullable|string',
            'varietal_type.*' => 'nullable|string',
            // 'vintage_brand_name' => 'required|string',
            'vintage_date' => 'nullable|digits:4|integer|between:1900,' . date('Y'),
            'description' => 'nullable|string',
            'abv' => 'nullable|numeric',
            'rs' => 'nullable|string',
            'rs_values' => 'nullable|array',
            'series' => 'nullable|string',
            'bottle_size' => 'nullable|string',
            'sku' => 'nullable|string',
            'cost' => 'nullable|numeric',
            'commission' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'cellar' => 'nullable|string',
            'inventory' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust image validation as needed
        ]);
        $rs = $request->input('rs');
        $rs_values = $request->input('rs_values');
        $rs_value = $rs_values[$rs];

        // Process varietal_blend and varietal_type
        $varietalBlends = $request->input('varietal_blend');
        $varietalTypes = $request->input('varietal_type');
        $grapeVarietals = $this->getVarietalNames($varietalTypes ?? []);
        // Combine into JSON format
        $varietalData = [];
        foreach ($varietalBlends as $index => $blend) {
            $varietalData[] = [
                'blend' => $blend,
                'type' => $varietalTypes[$index] ?? null,
            ];
        }

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public'); // Store image in public storage
        }
        // Create new VendorWine entry
        $data = [
            'vendor_id' => $vendor_id,
            // 'winery_name' => $request->input('winery_name'),
            'region' => $request->input('region') ?? null,
            'sub_region' => $request->input('sub_region') ?? null,
            'custom_region' => $request->input('custom_region') ?? null,
            'custom_sub_region' => $request->input('custom_sub_region') ?? null,
            'varietal_blend' => json_encode($varietalData) ?? null, // Store JSON data
            // 'vintage_brand_name' => $request->input('vintage_brand_name'),
            'grape_varietals' => $grapeVarietals ?? null,
            'vintage_date' => $request->input('vintage_date') ?? null,
            'description' => $request->input('description') ?? null,
            'abv' => $request->input('abv') ?? null,
            'rs' => $request->input('rs') ?? null,
            'rs_value' => $rs_value ?? null,
            'series' => $request->input('series') ?? null,
            'bottle_size' => $request->input('bottle_size') ?? null,
            'sku' => $request->input('sku') ?? null,
            'cost' => $request->input('cost') ?? 0.00,
            'cellar' => $request->input('cellar') ?? null,
            'commission_delivery_fee' => $request->input('commission') ?? 0.00,
            'price' => $request->input('price') ?? 0.00,
            'inventory' => $request->input('inventory') ?? 0,
            'image' => $imagePath,
        ];

        VendorWine::create($data);

        return response()->json(['success' => true, 'message' => 'Wine added successfully']);
    }

    public function update(Request $request, $id)
    {
        $wine = VendorWine::findOrFail($id);

        $request->validate([
            // 'winery_name' => 'required|string|min:2',
            'region' => 'nullable|string',
            'sub_region' => 'nullable|string',
            'custom_region' => 'nullable|string',
            'custom_sub_region' => 'nullable|string',
            'varietal_blend.*' => 'nullable|string',
            'varietal_type.*' => 'nullable|integer',
            // 'vintage_brand_name' => 'required|string',
            'vintage_date' => 'nullable|digits:4|integer|between:1900,' . date('Y'),
            'description' => 'nullable|string',
            'abv' => 'nullable|numeric',
            'rs' => 'nullable|string',
            'rs_values' => 'nullable|array',
            'series' => 'nullable|string',
            'bottle_size' => 'nullable|string',
            'sku' => 'nullable|string',
            'cost' => 'nullable|numeric',
            'commission' => 'nullable|numeric',
            'cellar' => 'nullable|string',
            'price' => 'nullable|numeric',
            'inventory' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust image validation as needed
        ]);

        // Process varietal_blend and varietal_type
        $varietalBlends = $request->input('varietal_blend');
        $varietalTypes = $request->input('varietal_type');
        $grapeVarietals = $this->getVarietalNames($varietalTypes ?? []);

        // Combine into JSON format
        $varietalData = [];
        foreach ($varietalBlends as $index => $blend) {
            $varietalData[] = [
                'blend' => $blend,
                'type' => $varietalTypes[$index] ?? null,
            ];
        }

        // Handle file upload
        $imagePath = $wine->image; // Get the current image path from the database

        if ($request->input('image_removed') == 'true') {
            // Delete the old image if it exists
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                $imagePath = null; // Set image path to null if the image is removed
            }
        }

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            // Store the new image
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public'); // Store image in public storage
        }

        // Update other fields in your model
        $wine->image = $imagePath;

        $rs = $request->input('rs');
        $rs_values = $request->input('rs_values');
        $rs_value = $rs_values[$rs];

        // Create new VendorWine entry
        $data = [
            // 'winery_name' => $request->input('winery_name'),
            'region' => $request->input('region'),
            'sub_region' => $request->input('sub_region'),
            'custom_region' => $request->input('custom_region'),
            'custom_sub_region' => $request->input('custom_sub_region'),
            'varietal_blend' => json_encode($varietalData), // Store JSON data
            // 'vintage_brand_name' => $request->input('vintage_brand_name'),
            'grape_varietals' => $grapeVarietals,
            'vintage_date' => $request->input('vintage_date'),
            'description' => $request->input('description'),
            'abv' => $request->input('abv'),
            'rs' => $request->input('rs'),
            'rs_value' => $rs_value,
            'bottle_size' => $request->input('bottle_size'),
            'series' => $request->input('series'),
            'sku' => $request->input('sku'),
            'cost' => $request->input('cost') ?? 0.00,
            'cellar' => $request->input('cellar') ?? null,
            'commission_delivery_fee' => $request->input('commission') ?? 0.00,
            'price' => $request->input('price') ?? 0.00,
            'inventory' => $request->input('inventory') ?? 0,
            'image' => $imagePath,
        ];
        
        $wine->update($data);

        return response()->json(['success' => true, 'message' => 'Wine updated successfully']);
    }


    public function delete($id, $vendorid)
    {

        try {
            // Find the wine entry by ID
            $wine = VendorWine::findOrFail($id);
            $imagePath = $wine->image;

            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            // Delete the wine entry
            $wine->delete();

            // Return a JSON response
            return response()->json(['success' => true, 'message' => 'Wine deleted successfully.']);
        } catch (\Exception $e) {
            // Return a JSON response for errors
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}