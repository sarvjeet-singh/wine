<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            [
                'name' => 'United States',
                'iso_code' => 'USA',
                'iso_code_2' => 'US',
                'dial_code' => '+1',
                'currency' => 'USD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Canada',
                'iso_code' => 'CAN',
                'iso_code_2' => 'CA',
                'dial_code' => '+1',
                'currency' => 'CAD',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
