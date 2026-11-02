<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Diskominfo',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
