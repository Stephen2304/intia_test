<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InsuranceType;

class InsuranceTypeSeeder extends Seeder
{
    public function run(): void
    {
        InsuranceType::create([
            'name' => 'Assurance Vie',
            'description' => 'Protection financière en cas de décès.',
            'coverage_details' => 'Décès, invalidité, maladie grave',
        ]);
        InsuranceType::create([
            'name' => 'Assurance Auto',
            'description' => 'Protection contre les accidents de la route.',
            'coverage_details' => 'Accident, vol, incendie',
        ]);
        InsuranceType::create([
            'name' => 'Assurance Santé',
            'description' => 'Remboursement des frais médicaux.',
            'coverage_details' => 'Hospitalisation, soins, médicaments',
        ]);
    }
} 