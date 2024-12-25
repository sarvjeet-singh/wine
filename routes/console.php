<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Vendor;


/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('vendor:add-short-code', function () {
    $vendors = Vendor::all();

    $this->info('Adding short codes to vendors without one...');

    foreach ($vendors as $vendor) {
        if (empty($vendor->short_code)) {
            do {
                $shortCode = generateYouTubeStyleId(null,8);
            } while (Vendor::where('short_code', $shortCode)->exists());

            $vendor->short_code = $shortCode;
            $vendor->save();

            $this->info("Added short code '{$shortCode}' to vendor ID {$vendor->id}");
        }
    }

    $this->info('Short code assignment complete!');
});
