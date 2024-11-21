<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Vendor;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email','markettingteam@winecountry.com')->first();
        $vendor = Vendor::where('vendor_email', 'winecountry@gmail.com')->first();

        Review::create([
            'user_id' => $user->id,
            'vendor_id' => $vendor->id,
            'review_description' => 'Register and have your say. Tell us about your wine country experience and those remarkable moments.',
            'rating' => 5.0,
            'review_status' => 'approved',
            'date_of_visit' => '2024-07-01'
        ]);
    }
}
