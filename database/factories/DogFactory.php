<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dog>
 */
class DogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'description' => fake()->text,
            'exercise_needs' => fake()->numberBetween(1, 10),
            'grooming_requirements' => fake()->numberBetween(1, 10),
            'trainability' => fake()->numberBetween(1, 10),
            'protectiveness' => fake()->numberBetween(1, 10),
        ];
    }
}
