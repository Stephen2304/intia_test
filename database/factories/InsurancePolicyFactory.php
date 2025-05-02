<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\InsuranceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class InsurancePolicyFactory extends Factory
{
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-1 year', 'now');
        $endDate = fake()->dateTimeBetween($startDate, '+1 year');

        return [
            'client_id' => Client::factory(),
            'insurance_type_id' => InsuranceType::factory(),
            'policy_number' => fake()->unique()->numerify('POL-########'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'coverage_amount' => fake()->randomFloat(2, 10000, 1000000),
            'annual_premium' => fake()->randomFloat(2, 1000, 10000),
            'status' => fake()->randomElement(['active', 'expired', 'cancelled']),
        ];
    }
} 