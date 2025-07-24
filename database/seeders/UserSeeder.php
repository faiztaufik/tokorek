<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Technician User',
            'email' => 'technician@example.com',
            'phone_number' => '081234567891',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone_number' => '081234567892',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
