<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Vendor;
use App\Models\VendorMediaGallery;

class UpdateVendorImageFolders extends Command
{
    protected $signature = 'update:vendor-image-folders';
    protected $description = 'Rename vendor image folders to use short_code and update related URLs';

    public function handle()
    {
        $vendors = Vendor::all();
        $basePath = public_path('images/VendorImages'); // Change this if the path differs

        foreach ($vendors as $vendor) {
            $oldFolder = $basePath . '/' . $vendor->vendor_name;
            $newFolder = $basePath . '/' . $vendor->short_code;

            // Check if old folder exists
            if (is_dir($oldFolder)) {
                // Rename the folder
                rename($oldFolder, $newFolder);
                $this->info("Renamed folder: {$vendor->vendor_name} -> {$vendor->short_code}");

                // Update vendor_media_galleries URLs
                VendorMediaGallery::where('vendor_media', 'like', "%images/VendorImages/{$vendor->vendor_name}%")
                    ->update([
                        'vendor_media' => \DB::raw("REPLACE(vendor_media, 'images/VendorImages/{$vendor->vendor_name}', 'images/VendorImages/{$vendor->short_code}')")
                    ]);

                $this->info("Updated media URLs for vendor: {$vendor->vendor_name}");
            } else {
                $this->warn("Folder not found for vendor: {$vendor->vendor_name}");
            }
        }

        $this->info("Vendor image folders and media URLs updated successfully.");
    }
}
