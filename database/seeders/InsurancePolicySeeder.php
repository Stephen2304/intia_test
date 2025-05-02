<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InsurancePolicy;
use App\Models\Client;
use App\Models\InsuranceType;
use Illuminate\Support\Str;

class InsurancePolicySeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();
        $types = InsuranceType::all();
        foreach ($clients as $client) {
            for ($i = 1; $i <= 2; $i++) {
                $type = $types->random();
                InsurancePolicy::create([
                    'client_id' => $client->id,
                    'insurance_type_id' => $type->id,
                    'policy_number' => strtoupper(Str::random(10)),
                    'start_date' => now()->subMonths(rand(1, 24)),
                    'end_date' => now()->addMonths(rand(1, 24)),
                    'coverage_amount' => rand(1000000, 10000000),
                    'annual_premium' => rand(50000, 500000),
                    'status' => 'active',
                ]);
            }
        }
    }
} 