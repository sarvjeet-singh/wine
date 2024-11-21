<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::create([
            'vendor_name' => 'Wine Country Weekends',
            'vendor_email' => 'winecountry@gmail.com',
            'street_address' => 'Niagara Falls',
        ]);
    }
}
