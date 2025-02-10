<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Vendor;
use App\Models\VendorMediaGallery;

class ImportVendorImages extends Command
{
    protected $signature = 'import:vendor-images';
    protected $description = 'Import vendor images from VendorImages folder and set the first image as default if none exists.';

    public function handle()
    {
        $vendors = Vendor::all();
        $basePath = public_path('images/VendorImages'); // Change this if the path differs

        foreach ($vendors as $vendor) {
            $vendorFolder = $basePath . '/' . $vendor->vendor_name;

            if (File::exists($vendorFolder) && File::isDirectory($vendorFolder)) {
                $images = File::files($vendorFolder);

                if (empty($images)) {
                    $this->warn("No images found for Vendor: {$vendor->vendor_name}");
                    continue;
                }

                // Check if a default image already exists in the DB
                $defaultExists = VendorMediaGallery::where('vendor_id', $vendor->id)
                    ->where('is_default', 1)
                    ->exists();

                $firstImage = true;

                foreach ($images as $image) {
                    $imageName = $image->getFilename();

                    // Check if the image already exists in the database
                    $exists = VendorMediaGallery::where('vendor_id', $vendor->id)
                        ->where('vendor_media', 'images/VendorImages/' . $vendor->vendor_name . '/' . $imageName)
                        ->exists();

                    if (!$exists) {
                        VendorMediaGallery::create([
                            'vendor_id' => $vendor->id,
                            'vendor_media_type' => 'image',
                            'is_default' => (!$defaultExists && $firstImage) ? 1 : 0,
                            'vendor_media' => 'images/VendorImages/' . $vendor->vendor_name . '/' . $imageName,
                        ]);

                        $this->info("Imported: $imageName for Vendor: {$vendor->vendor_name}");
                        $firstImage = false;
                    } else {
                        $this->warn("Skipped (Already Exists): $imageName for Vendor: {$vendor->vendor_name}");
                    }
                }
            } else {
                $this->error("Folder not found: {$vendor->vendor_name}");
            }
        }

        $this->info('Vendor image import completed.');
    }
}

