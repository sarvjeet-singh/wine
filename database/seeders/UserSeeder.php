<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'firstname' => 'Marketting',
            'lastname'  => 'Team',
            'email' => 'markettingteam@winecountry.com',
            'password' => bcrypt('12345678'),
            'profile_image' => 'marketing.png',
            'role' => 'marketting_team'
        ]);
    }
}
