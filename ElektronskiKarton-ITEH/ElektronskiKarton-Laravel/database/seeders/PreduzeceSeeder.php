<?php

namespace Database\Seeders;

use App\Models\Mesto;
use App\Models\Preduzece;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PreduzeceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mesta = Mesto::all();
        for ($i = 0; $i < 5; $i++) {
            $mesto = $mesta->random();
            Preduzece::create([
                'registarskiBroj' => fake()->unique()->numberBetween(10000,99999),
                'naziv' => fake()->sentence(3),
                'sifraDelatnosti' => fake()->unique()->numberBetween(1,70),
                'mesto_postanskiBroj' => $mesto->postanskiBroj
            ]);
        }
    }
}
