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
                'namacategory' => 'Frontline People',
                'keterangan' => 'Frontline People',
            ],
            [
                'namacategory' => 'Delivery Man',
                'keterangan' => 'Delivery Man',
            ],
            [
                'namacategory' => 'Sales',
                'keterangan' => 'Sales',
            ],
        ])->each(function ($dealer) {
            Category::create($dealer);
        });
    }
}
