<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Branch;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::all();
        foreach ($branches as $branch) {
            for ($i = 1; $i <= 5; $i++) {
                Client::create([
                    'branch_id' => $branch->id,
                    'code' => strtoupper(Str::random(6)),
                    'first_name' => 'Client' . $i,
                    'last_name' => $branch->name,
                    'birth_date' => now()->subYears(rand(18, 60)),
                    'address' => 'Adresse ' . $i,
                    'city' => $branch->location,
                    'phone' => '6' . rand(50000000, 99999999),
                    'email' => 'client' . $i . '@' . strtolower($branch->name) . '.com',
                ]);
            }
        }
    }
} 