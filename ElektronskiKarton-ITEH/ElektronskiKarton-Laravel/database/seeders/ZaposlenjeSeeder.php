<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Zaposlenje;
use App\Models\Karton;
use App\Models\Preduzece;


class ZaposlenjeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preduzeca = Preduzece::all();
        $kartoni=Karton::all();
        for ($i = 0; $i < 5; $i++) {
            $preduzece = $preduzeca->random();
            $karton = $kartoni->random();

            Zaposlenje::create([
                'karton_id' => $karton->id,
                'preduzece_registarskiBroj' => $preduzece->registarskiBroj,
                'posao' => fake()->sentence(2)
            ]);
        }
    }
}
