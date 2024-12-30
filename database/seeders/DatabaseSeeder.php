<?php

namespace Database\Seeders;
use App\Models\Doktor;
use App\Models\Dijagnoza;
use App\Models\Karton;
use App\Models\Terapija;
use App\Models\Sestra;
use App\Models\Preduzece;
use App\Models\Mesto;
use App\Models\Ustanova;
use App\Models\Pacijent;
use App\Models\Pregled;








use App\Models\User;
use App\Models\Zaposlenje;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Doktor::factory(3)->create();
        Dijagnoza::factory(5)->create();
        Terapija::factory(5)->create();
        Sestra::factory(2)->create();
        Mesto::factory(4)->create();
        Preduzece::factory(6)->create();

        $mesta=Mesto::all();
        for($i=0;$i<5;$i++){
            $mesto=$mesta->random();
            Ustanova::create([
                'naziv'=>fake()->sentence(4),
                'ulicaBroj'=>(fake()->sentence(3)).fake()->numberBetween(1,78),
                'mesto_id'=>$mesto->postanskiBroj
            ]);
        }

        for($i=0;$i<5;$i++){
            $mesto=$mesta->random();
            Pacijent::create([
                'jmbg'=>fake()->regexify('[0-9]{13}'),
                'email'=>fake()->email(),
                'password'=>fake()->password(),
                'imePrezime'=>fake()->name(),
                'imePrezimeNZZ'=>fake()->name(),
                'datumRodjenja'=>fake()->date(),
                'ulicaBroj'=>(fake()->sentence(3)).fake()->numberBetween(1,78),
                'telefon'=>fake()->phoneNumber(),
                'pol'=>fake()->random(['muski', 'zenski']),
                'bracniStatus'=>fake()->random(['u braku', 'nije u braku']),
                'mesto_id'=>$mesto->postanskiBroj
            ]);
        }

        $ustanove=Ustanova::all();
        $pacijenti=Pacijent::all();
        for($i=0;$i<5;$i++){
            $ustanova=$ustanove->random();
            $pacijent=$pacijenti->random();

            Karton::create([
                'brojKnjizice'=>fake()->regexify('[0-9]{10}'),
                'napomene'=>fake()->sentence(4),
                'ustanova_id'=>$ustanova->id,
                'pacijent_id'=>$pacijent->jmbg
            ]);
        }



        $doktori=Doktor::all();
        $sestre=Sestra::all();
        $terapije=Terapija::all();
        $dijagnoze=Dijagnoza::all();
        $kartoni=Karton::all();
        for($i=0;$i<5;$i++){
            $doktor=$doktori->random();
            $sestra=$sestre->random();
            $terapija=$terapije->random();
            $dijagnoza=$dijagnoze->random();
            $karton=$kartoni->random();

            Pregled::create([
                'datum'=>fake()->date(),
                'doktor_id'=>$doktor->id,
                'sestra_id'=>$sestra->id,
                'terappija_id'=>$terapija->id,
                'dijagnoza_id'=>$dijagnoza->id,
                'karton_id'=>$karton->id
            ]);
        }



        $preduzeca=Preduzece::all();
        for($i=0;$i<5;$i++){
            $preduzece=$preduzeca->random();
            $karton=$kartoni->random();

            Zaposlenje::create([
                'karton_id'=>$karton->id,
                'preduzece_id'=>$preduzece->registarskiBroj,
                'posao'=>fake()->sentence(2)
            ]);
        }



        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
