<?php

namespace Database\Seeders;

use App\Models\Juri;
use App\Models\User;
use App\Models\Peserta;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $peserta = Peserta::create([
            'nama' => 'Peserta 1', 
            'email' => 'peserta1@example.com', 
            'honda_id' => 'K2772822',
            'category_id' => '1',
            'maindealer_id' => '1',
        ]);

        // Membuat juri
        $juri = Juri::create([
            'namajuri' => 'Juri 1', 
        ]);
        collect([
            [
                'username' => 'Taufiq14',
                'password' => bcrypt('password'),
                'role' => 'peserta',
                'peserta_id' => $peserta->id,  
                'juri_id' => null,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'juri990',
                'password' => bcrypt('password'),
                'role' => 'juri',
                'peserta_id' => null,  
                'juri_id' => $juri->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ])->each(function ($users) {
            User::create($users);
        });
    }
}
