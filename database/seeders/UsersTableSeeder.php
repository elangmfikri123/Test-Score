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

        // Juri
        for ($i = 1; $i <= 2; $i++) {
            $user = User::create([
                'username' => 'juri' . $i,
                'password' => bcrypt('12345'),
                'role' => 'Juri',
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
            // Admin
            $user = User::create([
                'username' => 'admin.ahm' . $i,
                'password' => bcrypt('12345'),
                'role' => 'Admin',
            ]);

            Admin::create([
                'user_id' => $user->id,
                'nama_lengkap' => 'Admin ' . $i,
                'email' => 'admin' . $i . '@example.com',
                'maindealer_id' => null,
            ]);

            // AdminMD
            $userMD = User::create([
                'username' => 'adminmd.ahm' . $i,
                'password' => bcrypt('12345'),
                'role' => 'AdminMD',
            ]);

            Admin::create([
                'user_id' => $userMD->id,
                'nama_lengkap' => 'Admin MD' . $i,
                'email' => 'adminmd' . $i . '@example.com',
                'maindealer_id' => 2,
            ]);
        }
    }
}
