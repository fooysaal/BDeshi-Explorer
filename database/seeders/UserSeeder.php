<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bdeshi-explorer.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'phone' => '+8801700000001',
            'address' => 'Dhaka, Bangladesh',
            'email_verified_at' => now(),
        ]);

        // Create Moderator User
        User::create([
            'name' => 'Moderator User',
            'email' => 'moderator@bdeshi-explorer.com',
            'password' => Hash::make('password'),
            'role' => 'moderator',
            'is_active' => true,
            'phone' => '+8801700000002',
            'address' => 'Dhaka, Bangladesh',
            'email_verified_at' => now(),
        ]);

        // Create Explorer Users
        User::create([
            'name' => 'John Explorer',
            'email' => 'explorer@example.com',
            'password' => Hash::make('password'),
            'role' => 'explorer',
            'is_active' => true,
            'phone' => '+8801700000003',
            'address' => 'Dhaka, Bangladesh',
            'email_verified_at' => now(),
        ]);

        // Create additional explorer users
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Explorer User {$i}",
                'email' => "explorer{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'explorer',
                'is_active' => true,
                'phone' => "+880170000000{$i}",
                'address' => 'Bangladesh',
                'email_verified_at' => now(),
            ]);
        }
    }
}
