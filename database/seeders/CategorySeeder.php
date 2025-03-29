<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Seni dan Hiburan', 'Teknologi', 'Pendidikan', 'Olahraga'];

        foreach ($categories as $category) {
            Categorie::create(['name' => $category]);
        }
    }
}
