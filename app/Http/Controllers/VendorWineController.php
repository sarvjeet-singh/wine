<?php

namespace App\Http\Controllers;

use App\Models\VendorWine;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorWineController extends Controller
{
    // Define a common array for varietal type mappings
    private $varietalNames;

    public function __construct()
    {
        $this->varietalNames = $this->mapGrapeVarietals();
    }

    private function mapGrapeVarietals(): array
    {
        $grapeVarietals = getGrapeVarietals();

        // Map IDs to names for quick access
        $mappedVarietals = [];
        foreach ($grapeVarietals as $varietal) {
            $mappedVarietals[$varietal->id] = $varietal->name;
        }

        return $mappedVarietals;
    }

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
            ->orderBy('delisted', 'asc') // Non-delisted first
            ->orderBy('id', 'desc') // Then sort by ID descending within each group
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
            'winery_name' => 'required|string|min:2',
            'region' => 'nullable|string',
            'sub_region' => 'nullable|string',
            'varietal_blend.*' => 'nullable|string',
            'varietal_type.*' => 'nullable|string',
            'vintage_date' => 'nullable|digits:4|integer|between:1900,' . date('Y'),
            'description' => 'nullable|string',
            'abv' => 'nullable|numeric',
            'rs' => 'nullable|string',
            'rs_values' => 'nullable|array',
            'series' => 'nullable|string',
            'bottle_size' => 'nullable|string',
            'sku' => 'nullable|string',
            'retail_price' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'commission' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'cellar' => 'nullable|string',
            'inventory' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf' => 'nullable|mimes:pdf|max:5120',
            'status' => 'nullable|boolean',
        ]);

        $rs_value = null;
        if (!empty($request->input('rs')) && !empty($request->input('rs_values'))) {
            $rs = $request->input('rs');
            $rs_values = $request->input('rs_values');
            $rs_value = $rs_values[$rs] ?? null;
        }

        $varietalBlends = $request->input('varietal_blend');
        $varietalTypes = $request->input('varietal_type');
        $grapeVarietals = $this->getVarietalNames($varietalTypes ?? []);

        $varietalData = [];
        foreach ($varietalBlends as $index => $blend) {
            if (!empty($blend) || !empty($varietalTypes[$index])) {
                $varietalData[] = [
                    'blend' => $blend,
                    'type' => $varietalTypes[$index] ?? null,
                ];
            }
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
        }

        $pdfPath = null;
        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('pdfs', 'public');
        }

        $vendorWine = new VendorWine();
        $vendorWine->vendor_id = $vendor_id;
        $vendorWine->winery_name = $request->input('winery_name');
        $vendorWine->region = $request->input('region') ?? null;
        $vendorWine->sub_region = $request->input('sub_region') ?? null;
        $vendorWine->varietal_blend = json_encode($varietalData) ?? null;
        $vendorWine->grape_varietals = $grapeVarietals ?? null;
        $vendorWine->vintage_date = $request->input('vintage_date') ?? null;
        $vendorWine->description = $request->input('description') ?? null;
        $vendorWine->abv = $request->input('abv') ?? null;
        $vendorWine->rs = $request->input('rs') ?? null;
        $vendorWine->rs_value = $rs_value ?? null;
        $vendorWine->series = $request->input('series') ?? null;
        $vendorWine->bottle_size = $request->input('bottle_size') ?? null;
        $vendorWine->sku = $request->input('sku') ?? null;
        $vendorWine->retail_price = $request->input('retail_price') ?? null;
        $vendorWine->cost = $request->input('cost') ?? null;
        $vendorWine->cellar = $request->input('cellar') ?? null;
        $vendorWine->commission_delivery_fee = $request->input('commission') ?? null;
        $vendorWine->price = $request->input('price') ?? null;
        $vendorWine->inventory = $request->input('inventory') ?? 0;
        $vendorWine->image = $imagePath;
        $vendorWine->delisted = $request->input('status') == 1 ? 0 : 1;
        $vendorWine->pdf = $pdfPath;

        if (!empty($vendorWine->cost)) {
            $calculations = calculateStockingFeeAndPrice($vendorWine->cost);
            $vendorWine->commission_delivery_fee = $calculations['stocking_fee'];
            $vendorWine->price = $calculations['final_price'];
        }

        $vendorWine->save();

        return redirect()->route('vendor-wines.index', $vendor_id)->with('success', 'Wine added successfully.');
    }

    public function update(Request $request, $id)
    {
        $wine = VendorWine::findOrFail($id);

        $request->validate([
            'winery_name' => 'required|string|min:2',
            'region' => 'nullable|string',
            'sub_region' => 'nullable|string',
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
            'retail_price' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'commission' => 'nullable|numeric',
            'cellar' => 'nullable|string',
            'price' => 'nullable|numeric',
            'inventory' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust image validation as needed
            'pdf' => 'nullable|mimes:pdf|max:5120',
            'remove_pdf' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        // Process varietal_blend and varietal_type
        $varietalBlends = $request->input('varietal_blend');
        $varietalTypes = $request->input('varietal_type');
        $grapeVarietals = $this->getVarietalNames($varietalTypes ?? []);

        // Combine into JSON format
        $varietalData = [];
        foreach ($varietalBlends as $index => $blend) {
            if (!empty($blend) || !empty($varietalTypes[$index])) {
                $varietalData[] = [
                    'blend' => $blend,
                    'type' => $varietalTypes[$index] ?? null,
                ];
            }
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

        // Handle PDF upload
        $pdfPath = $wine->pdf; // Get the current PDF path from the database
        if ($request->input('remove_pdf')) {
            // Delete the old PDF if it exists
            if ($pdfPath && Storage::disk('public')->exists($pdfPath)) {
                Storage::disk('public')->delete($pdfPath);
                $pdfPath = null; // Set PDF path to null if the PDF is removed
            }
        }

        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('pdfs', 'public'); // Store in storage/app/public/pdfs
        }

        // Update other fields in your model
        $wine->image = $imagePath;
        $rs_value = null;

        if (!empty($request->input('rs')) && !empty($request->input('rs_values'))) {
            $rs = $request->input('rs');
            $rs_values = $request->input('rs_values');
            $rs_value = $rs_values[$rs];
        }

        // Create new VendorWine entry
        $data = [
            'winery_name' => $request->input('winery_name'),
            'region' => $request->input('region'),
            'sub_region' => $request->input('sub_region'),
            'varietal_blend' => json_encode($varietalData),
            'grape_varietals' => $grapeVarietals,
            'vintage_date' => $request->input('vintage_date'),
            'description' => $request->input('description'),
            'abv' => $request->input('abv'),
            'rs' => $request->input('rs'),
            'rs_value' => $rs_value,
            'bottle_size' => $request->input('bottle_size'),
            'series' => $request->input('series'),
            'sku' => $request->input('sku'),
            'retail_price' => $request->input('retail_price') ?? null,
            'cost' => $request->input('cost') ?? null,
            'cellar' => $request->input('cellar') ?? null,
            'commission_delivery_fee' => $request->input('commission') ?? null,
            'price' => $request->input('price') ?? null,
            'inventory' => $request->input('inventory') ?? 0,
            'image' => $imagePath,
            'pdf' => $pdfPath,
            'delisted' => $request->input('status') == 1 ? 0 : 1,
        ];

        // Use the private method to calculate stocking fee and final price
        if (!empty($data['cost'])) {
            $calculations = calculateStockingFeeAndPrice($data['cost']);
            $data['commission_delivery_fee'] = $calculations['stocking_fee'];
            $data['price'] = $calculations['final_price'];
        }

        $wine->update($data);

        return redirect()->route('vendor-wines.index', $wine->vendor_id)->with('success', 'Wine updated successfully.');
    }


    public function delete($id, $vendorid)
    {

        try {
            // Find the wine entry by ID
            $wine = VendorWine::findOrFail($id);
            if ($wine) {
                if ($wine->delisted == 1) {
                    $wine->delisted = 0; // Mark as listed
                    $message = 'Wine listed successfully.';
                } else {
                    $wine->delisted = 1; // Mark as delisted
                    $message = 'Wine delisted successfully.';
                }

                $wine->save();
            } else {
                return response()->json(['success' => false, 'message' => 'Wine not found.']);
            }
            // $imagePath = $wine->image;

            // if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            //     Storage::disk('public')->delete($imagePath);
            // }

            // // Delete the wine entry
            // $wine->delete();

            // Return a JSON response
            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            // Return a JSON response for errors
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function checkWineName(Request $request)
    {
        $wineName = $request->input('winery_name');
        $wine_id = $request->input('wine_id');
        if (!empty($wine_id)) {
            $exists = VendorWine::where('winery_name', $wineName)->where('id', '!=', $wine_id)->exists();
            return response()->json(!$exists);
        }
        $exists = VendorWine::where('winery_name', $wineName)->exists();
        return response()->json(!$exists); // true if not exists (valid), false if exists (invalid)
    }
}
