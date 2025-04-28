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
                'nama_md' => 'ASTRA HONDA MOTOR',
            ],
            [
                'kodemd' => 'B10',
                'nama_md' => 'INDAKO TRADING COY',
            ],
            [
                'kodemd' => 'B3Z',
                'nama_md' => 'CDN-ACEH',
            ],
            [
                'kodemd' => 'C3Z',
                'nama_md' => 'HAYATI PRATAMA MANDIRI',
            ],
            [
                'kodemd' => 'D2Z',
                'nama_md' => 'CAPELLA DINAMIK NUSANTARA - RIAU DARATAN',
            ],
            [
                'kodemd' => 'D3Z',
                'nama_md' => 'CAPELLA DINAMIK NUSANTARA - KEPULAUAN RIAU',
            ],
            [
                'kodemd' => 'E20',
                'nama_md' => 'SINAR SENTOSA PRIMATAMA',
            ],
            [
                'kodemd' => 'G01',
                'nama_md' => 'ASTRA MOTOR SUMATERA SELATAN',
            ],
            [
                'kodemd' => 'G02',
                'nama_md' => 'ASTRA MOTOR BENGKULU',
            ], 
            [
                'kodemd' => 'G5Z',
                'nama_md' => 'ASIA SURYA PERKASA',
            ],
            [
                'kodemd' => 'H2Z',
                'nama_md' => 'TUNAS DWIPA MATRA',
            ],
            [
                'kodemd' => 'I01',
                'nama_md' => 'ASTRA MOTOR JAKARTA',
            ],
            [
                'kodemd' => 'I3Z',
                'nama_md' => 'WAHANA MAKMUR SEJATI',
            ],
            [
                'kodemd' => 'J10',
                'nama_md' => 'DAYA ADICIPTA MOTORA',
            ],
            [
                'kodemd' => 'J20',
                'nama_md' => 'MITRA SENDANG KEMAKMURAN',
            ],
            [
                'kodemd' => 'K0Z',
                'nama_md' => 'ASTRA MOTOR JAWA TENGAH',
            ],
            [
                'kodemd' => 'L01',
                'nama_md' => 'ASTRA MOTOR DIY',
            ],
            [
                'kodemd' => 'M2Z',
                'nama_md' => 'MITRA PINASTHIKA MULIA-SBY',
            ],
            [
                'kodemd' => 'M3Z',
                'nama_md' => 'MITRA PINASTHIKA MULIA-MLG',
            ],
            [
                'kodemd' => 'N01',
                'nama_md' => 'ASTRA MOTOR BALI',
            ],
            [
                'kodemd' => 'N02',
                'nama_md' => 'ASTRA MOTOR NTB',
            ],
            [
                'kodemd' => 'Q01',
                'nama_md' => 'ASTRA MOTOR KALBAR',
            ],
            [
                'kodemd' => 'R4Z',
                'nama_md' => 'ASTRA MOTOR KALTIM-1 (BALIKPAPAN)',
            ],
            [
                'kodemd' => 'R5Z',
                'nama_md' => 'ASTRA MOTOR KALTIM-2 (SAMARINDA)',
            ],
            [
                'kodemd' => 'T10',
                'nama_md' => 'TRIO MOTOR',
            ],
            [
                'kodemd' => 'U10',
                'nama_md' => 'DAYA ADICIPTA WISESA',
            ],
            [
                'kodemd' => 'V2Z',
                'nama_md' => 'ANUGERAH PERDANA',
            ],
            [
                'kodemd' => 'W01',
                'nama_md' => 'ASTRA MOTOR SULAWESI SELATAN',
            ],
            [
                'kodemd' => 'Z11',
                'nama_md' => 'ASTRA MOTOR PAPUA',
            ],
            
        ])->each(function ($dealer) {
            MainDealer::create($dealer);
        });
    }
}
