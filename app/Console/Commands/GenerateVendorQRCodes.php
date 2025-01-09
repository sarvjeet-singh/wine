<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vendor; // Replace with your Vendor model namespace
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Facades\Image;

class GenerateVendorQRCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendors:generate-qr-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate QR codes for all vendors and save the path in their records.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $vendors = Vendor::all();

        if ($vendors->isEmpty()) {
            $this->info('No vendors found.');
            return 0;
        }

        foreach ($vendors as $vendor) {
            try {
                $qrCodeData = route('vendorQCode.show', [
                    'short_code' => $vendor->short_code,
                    'redirect' => 'register', // Adjust redirect route as needed
                ]);
    
                $qrCodePath = 'images/VendorQRCodes/' . $vendor->vendor_name . '-' . $vendor->short_code . '.png';
    
                // Ensure the directory exists
                if (!file_exists(public_path('images/VendorQRCodes'))) {
                    mkdir(public_path('images/VendorQRCodes'), 0777, true);
                }
    
                // Generate QR code as a temporary image
                $qrCode = QrCode::format('png')
                    ->size(350) // Set the size of the QR code
                    ->margin(1) // Add some margin around the QR code
                    ->generate($qrCodeData);
    
                $qrCodeTempPath = 'images/VendorQRCodes/' . $vendor->vendor_name . '-' . $vendor->short_code . '_temp.png';
                $qrCodeTempPath = public_path($qrCodeTempPath);
                file_put_contents($qrCodeTempPath, $qrCode);
    
                // Load the QR code image
                $qrCodeImage = Image::make($qrCodeTempPath);
    
                // Prepare the circular background with the logo
                $logoPath = public_path('images/logo-leaf.png');
                if (file_exists($logoPath)) {
                    $logo = Image::make($logoPath)->resize(65, 65); // Resize the logo
                    // Add the circular canvas with the logo to the center of the QR code
                    $qrCodeImage->insert($logo, 'center');
                }
    
                // Save the final QR code with the logo
                $qrCodeImage->save(public_path($qrCodePath));
    
                // Clean up the temporary file
                unlink($qrCodeTempPath);
    
                // Save the QR code path to the vendor
                $vendor->qr_code = $qrCodePath;
                $vendor->save();

                $this->info("QR code generated and saved for vendor: {$vendor->vendor_name}");
            } catch (\Exception $e) {
                $this->error("Failed to generate QR code for vendor: {$vendor->vendor_name}. Error: {$e->getMessage()}");
            }
        }

        $this->info('QR code generation completed for all vendors.');
        return 0;
    }
}
