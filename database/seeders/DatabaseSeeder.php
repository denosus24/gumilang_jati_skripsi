<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
       $this->call(AdminUsersTableSeeder::class);
       $this->call(MarketingUsersTableSeeder::class);
       $this->call(ServiceCategoriesTableSeeder::class);
       $this->call(ServicesTableSeeder::class);
       $this->call(PackagesTableSeeder::class);
    }
}
