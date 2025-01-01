<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mesto;
use App\Models\Pacijent;

class PacijentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mesta=Mesto::all();
        for ($i = 0; $i < 5; $i++) {
            $mesto = $mesta->random();
            Pacijent::create([
                'jmbg' => fake()->regexify('[0-9]{13}'),
                'email' => fake()->email(),
                'password' => fake()->password(),
                'imePrezime' => fake()->name(),
                'imePrezimeNZZ' => fake()->name(),
                'datumRodjenja' => fake()->date(),
                'ulicaBroj' => (fake()->sentence(3)) . fake()->numberBetween(1, 78),
                'telefon' => fake()->phoneNumber(),
                'pol' => fake()->randomElement(['muski', 'zenski']),
                'bracniStatus' => fake()->randomElement(['u braku', 'nije u braku']),
                'mesto_postanskiBroj' => $mesto->postanskiBroj
            ]);
        }
    }
}
