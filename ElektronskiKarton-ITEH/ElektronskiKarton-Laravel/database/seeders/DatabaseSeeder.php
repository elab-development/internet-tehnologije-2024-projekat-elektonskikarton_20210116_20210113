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
        for($i = 0; $i < 3; $i++){
            User::factory()->create([
                'role' => 'doktor'
            ]);
        }
        for($i = 0; $i < 3; $i++){
            User::factory()->create([
                'role' => 'sestra'
            ]);
        }
        for($i = 0; $i < 5; $i++){
            User::factory()->create([
                'role' => 'pacijent'
            ]);
        }
        User::factory()->create([
            'role' => 'admin'
        ]);

        $this->call(DoktorSeeder::class);
        $this->call(SestraSeeder::class);
        Dijagnoza::factory(5)->create();
        Terapija::factory(5)->create();
        Mesto::factory(4)->create();

        $this->call(PreduzeceSeeder::class);
        $this->call(UstanovaSeeder::class);
        $this->call(PacijentSeeder::class);
        $this->call(KartonSeeder::class);
        $this->call(PregledSeeder::class);
        $this->call(ZaposlenjeSeeder::class);




    }
}
