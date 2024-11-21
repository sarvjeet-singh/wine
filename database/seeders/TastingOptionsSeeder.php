<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TastingOption;

class TastingOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            ['name' => 'Appointment Only'],
            ['name' => 'Drop-Ins Welcome'],
            ['name' => 'Tasting w/Pairings'],
            ['name' => 'Not Offered'],
        ];

        foreach ($options as $option) {
            TastingOption::create($option);
        }
    }
}
