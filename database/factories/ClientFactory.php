<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'branch_id' => Branch::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'date_of_birth' => fake()->date(),
            'gender' => fake()->randomElement(['male', 'female']),
            'occupation' => fake()->jobTitle(),
            'national_id' => fake()->unique()->numerify('##########'),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
} 