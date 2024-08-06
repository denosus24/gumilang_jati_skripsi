<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MarketingUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email'     => 'marketing@gmail.com',
            ],
            [
                'name'              => 'Admin Marketing',
                'password'          => Hash::make('12345678'),
                'role'              => 'marketing',
                'email_verified_at' => now(),
            ]
        );
    }
}
