<?php

namespace Database\Seeders;

use App\Models\MainDealer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MainDealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'kodemd' => 'AHM',
                'nama_md' => 'Astra Honda Motor',
            ],
            [
                'kodemd' => 'B10',
                'nama_md' => 'Menara Agung',
            ]
        ])->each(function ($dealer) {
            MainDealer::create($dealer);
        });
    }
}
