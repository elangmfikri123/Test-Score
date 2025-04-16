<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Peserta;
use App\Models\Juri;
use App\Models\Admin;
use App\Models\AdminMD;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Peserta
        for ($i = 1; $i <= 2; $i++) {
            $user = User::create([
                'username' => 'peserta' . $i,
                'password' => bcrypt('password'),
                'role' => 'peserta',
            ]);

            Peserta::create([
                'user_id' => $user->id,
                'nama' => 'Peserta ' . $i,
                'email' => 'peserta' . $i . '@example.com',
                'honda_id' => 'HND' . rand(1000, 9999),
                'maindealer_id' => 1,
                'category_id' => 1,
                'dealer' => 'Dealer ' . $i,
            ]);
        }

        // Juri
        for ($i = 1; $i <= 2; $i++) {
            $user = User::create([
                'username' => 'juri' . $i,
                'password' => bcrypt('password'),
                'role' => 'juri',
            ]);

            Juri::create([
                'user_id' => $user->id,
                'namajuri' => 'Juri ' . $i,
                'jabatan' => 'Jabatan ' . $i,
                'division' => 'Divisi ' . $i,
                'email' => 'juri' . $i . '@example.com',
            ]);
        }

        // Admin
        for ($i = 1; $i <= 2; $i++) {
            $user = User::create([
                'username' => 'admin' . $i,
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);

            Admin::create([
                'user_id' => $user->id,
                'nama_lengkap' => 'Admin ' . $i,
                'email' => 'admin' . $i . '@example.com',
            ]);
        }

        // Admin MD
        for ($i = 1; $i <= 2; $i++) {
            $user = User::create([
                'username' => 'adminmd' . $i,
                'password' => bcrypt('password'),
                'role' => 'adminmd',
            ]);

            AdminMD::create([
                'user_id' => $user->id,
                'nama_lengkap' => 'Admin MD ' . $i,
                'email' => 'adminmd' . $i . '@example.com',
                'maindealer_id' => 1,
            ]);
        }
    }
}
