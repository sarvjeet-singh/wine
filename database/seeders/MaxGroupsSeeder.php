<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MaxGroup;

class MaxGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            ['name' => '1-2 People'],
            ['name' => '3-4 People'],
            ['name' => '5-6 People'],
            ['name' => 'Contact Vendor'],
        ];

        foreach ($groups as $group) {
            MaxGroup::create($group);
        }
    }
}
