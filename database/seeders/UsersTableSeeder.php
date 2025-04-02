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
            'nama' => 'Peserta 1',  // Sesuaikan dengan field yang ada di tabel peserta
            'email' => 'peserta1@example.com',  // Sesuaikan dengan field yang ada
            'honda_id' => 'H123',
            'maindealer_id' => '1',
        ]);

        // Membuat juri
        $juri = Juri::create([
            'namajuri' => 'Juri 1',  // Sesuaikan dengan field yang ada di tabel juri
        ]);
        collect([
            [
                'username' => 'peserta123',
                'password' => bcrypt('password'),
                'role' => 'peserta',
                'peserta_id' => $peserta->id,  // ID peserta yang sudah dibuat
                'juri_id' => null,  // Kosongkan karena ini peserta
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'juri123',
                'password' => bcrypt('password'),
                'role' => 'juri',
                'peserta_id' => null,  // Kosongkan karena ini juri
                'juri_id' => $juri->id,  // ID juri yang sudah dibuat
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ])->each(function ($users) {
            User::create($users);
        });
    }
}
