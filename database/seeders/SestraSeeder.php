<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Sestra;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SestraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role','sestra')->get();

        forEach($users as $user){
            Sestra::create([
                'user_id'=>$user->id
            ]);
        }
    }
}
