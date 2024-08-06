<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceCategory::firstOrCreate(['code' => 'SMM'], ['name' => 'Manajemen Sosial Media']);
        ServiceCategory::firstOrCreate(['code' => 'KOL'], ['name' => 'Manajemen KOL']);
    }
}
