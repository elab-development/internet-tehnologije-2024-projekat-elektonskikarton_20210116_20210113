<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mesto;
use App\Models\Ustanova;


class UstanovaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mesta = Mesto::all();
        for ($i = 0; $i < 5; $i++) {
            $mesto = $mesta->random();
            Ustanova::create([
                'naziv' => fake()->sentence(4),
                'ulicaBroj' => (fake()->sentence(3)) . fake()->numberBetween(1, 78),
                'mesto_postanskiBroj' => $mesto->postanskiBroj
            ]);
        }
    }
}
