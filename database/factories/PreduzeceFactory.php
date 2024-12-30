<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Preduzece>
 */
class PreduzeceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registarskiBroj'=>fake()->unique()->numberBetween(10000000-99999999),
            'naziv'=>fake()->sentence(3),
            'sifraDelatnosti'=>fake()->numberBetween(100-999)
        ];
    }
}
