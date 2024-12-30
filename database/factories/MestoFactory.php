<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mesto>
 */
class MestoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'postanskiBroj'=>fake()->unique()->numberBetween(10000,99999),
            'naziv'=>fake()->sentence(2)
        ];
    }
}
