<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email'     => 'superadmin@email.com',
            ],
            [
                'name'              => 'Super Admin',
                'password'          => Hash::make('12345678'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
