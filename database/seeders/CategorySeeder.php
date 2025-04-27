<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
                'namacategory' => 'Frontline People Sales',
                'keterangan' => 'FLP SALES',
            ],
            [
                'namacategory' => 'Frontline People Non Sales',
                'keterangan' => 'FLP NON SALES',
            ],
            [
                'namacategory' => 'Delivery Man',
                'keterangan' => 'DVM',
            ],
            [
                'namacategory' => 'Team Leader',
                'keterangan' => 'TEAM LEADER',
            ],
            [
                'namacategory' => 'Pimpinan Jaringan',
                'keterangan' => 'PINJAR',
            ],
            [
                'namacategory' => 'Customer Relation Officer',
                'keterangan' => 'CRO',
            ],
        ])->each(function ($dealer) {
            Category::create($dealer);
        });
    }
}
