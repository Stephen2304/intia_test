<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'branch_id' => Branch::factory(),
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'birth_date' => fake()->date(),
            'city' => fake()->city(),
            'code' => Str::random(10),
        ];
    }
} 