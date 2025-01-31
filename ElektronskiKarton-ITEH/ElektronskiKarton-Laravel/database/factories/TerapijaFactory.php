<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Terapija>
 */
class TerapijaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'naziv'=>fake()->sentence(5),
            'opis'=>fake()->paragraph(3),
            'trajanje'=>fake()->numberBetween(1,60)
        ];
    }
}
