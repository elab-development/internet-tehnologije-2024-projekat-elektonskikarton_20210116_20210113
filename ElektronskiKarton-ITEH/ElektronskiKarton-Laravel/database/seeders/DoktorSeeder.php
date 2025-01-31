<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doktor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DoktorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role','doktor')->get();

        forEach($users as $user){
            Doktor::create([
                'user_id'=>$user->id,
                'specijalizacija'=>fake()->sentence(1)
            ]);
        }
    }
}
