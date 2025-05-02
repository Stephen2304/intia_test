<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InsuranceTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Assurance Auto',
                'Assurance Habitation',
                'Assurance Santé',
                'Assurance Vie',
                'Assurance Voyage'
            ]),
            'description' => fake()->sentence(),
            'coverage_details' => fake()->paragraph(),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
} 