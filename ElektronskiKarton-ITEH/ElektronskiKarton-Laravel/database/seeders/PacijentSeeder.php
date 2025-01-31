<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mesto;
use App\Models\Pacijent;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PacijentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mesta=Mesto::all();
        $users = User::where('role','pacijent')->get();

        forEach($users as $user){
            $mesto = $mesta->random();
            Pacijent::create([
                'user_id' => $user->id,
                'jmbg' => fake()->regexify('[0-9]{13}'),
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
