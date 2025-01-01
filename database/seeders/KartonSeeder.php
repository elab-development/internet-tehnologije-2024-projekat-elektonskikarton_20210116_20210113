<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ustanova;
use App\Models\Pacijent;
use App\Models\Karton;


class KartonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $ustanove = Ustanova::all();
        $pacijenti = Pacijent::all();
        for ($i = 0; $i < 5; $i++) {
            $ustanova = $ustanove->random();
            $pacijent = $pacijenti->random();

            Karton::create([
                'brojKnjizice' => fake()->regexify('[0-9]{10}'),
                'napomene' => fake()->sentence(4),
                'ustanova_id' => $ustanova->id,
                'pacijent_jmbg' => $pacijent->jmbg
            ]);
        }
    }
}
