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

                // Properly escape vendor_name and short_code to avoid syntax errors
                $oldPath = "images/VendorImages/{$vendor->vendor_name}";
                $newPath = "images/VendorImages/{$vendor->short_code}";

                // Update vendor_media_galleries URLs safely using parameter binding
                \DB::update(
                    "UPDATE vendor_media_galleries SET vendor_media = REPLACE(vendor_media, ?, ?), updated_at = NOW() WHERE vendor_media LIKE ?",
                    [$oldPath, $newPath, "%$oldPath%"]
                );

                $this->info("Updated media URLs for vendor: {$vendor->vendor_name}");
            } else {
                $this->warn("Folder not found for vendor: {$vendor->vendor_name}");
            }
        }

        $this->info("Vendor image folders and media URLs updated successfully.");
    }
}
