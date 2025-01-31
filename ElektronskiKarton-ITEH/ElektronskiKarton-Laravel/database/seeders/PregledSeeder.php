<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doktor;
use App\Models\Sestra;
use App\Models\Terapija;
use App\Models\Dijagnoza;
use App\Models\Karton;
use App\Models\Pregled;




class PregledSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doktori = Doktor::all();
        $sestre = Sestra::all();
        $terapije = Terapija::all();
        $dijagnoze = Dijagnoza::all();
        $kartoni = Karton::all();
        for ($i = 0; $i < 5; $i++) {
            $doktor = $doktori->random();
            $sestra = $sestre->random();
            $terapija = $terapije->random();
            $dijagnoza = $dijagnoze->random();
            $karton = $kartoni->random();

            Pregled::create([
                'datum' => fake()->date(),
                'doktor_id' => $doktor->id,
                'sestra_id' => $sestra->id,
                'terapija_id' => $terapija->id,
                'dijagnoza_id' => $dijagnoza->id,
                'karton_id' => $karton->id
            ]);
        }
    }
}
