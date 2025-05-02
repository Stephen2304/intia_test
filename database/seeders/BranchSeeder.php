<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create(['name' => 'Direction Générale', 'location' => 'Douala', 'contact_info' => 'contact@intia.com']);
        Branch::create(['name' => 'Douala', 'location' => 'Douala', 'contact_info' => 'douala@intia.com']);
        Branch::create(['name' => 'Yaoundé', 'location' => 'Yaoundé', 'contact_info' => 'yaounde@intia.com']);
    }
} 