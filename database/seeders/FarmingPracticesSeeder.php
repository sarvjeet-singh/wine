<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FarmingPractice;

class FarmingPracticesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $practices = [
            ['name' => 'Conventional'],
            ['name' => 'Natural'],
            ['name' => 'Organic'],
            ['name' => 'Bio-Dynamic'],
        ];

        foreach ($practices as $practice) {
            FarmingPractice::create($practice);
        }
    }
}
