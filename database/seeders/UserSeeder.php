<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::create([
            'name'          => 'Administrator',
            'email'         => 'admin@lunarity.com',
            'password'      => Hash::make('password'),
            'role'          => 'admin',
            'date_of_birth' => '1990-01-01',
        ]);

        // Sample guests
        User::create([
            'name'          => 'John Doe',
            'email'         => 'john@example.com',
            'password'      => Hash::make('password'),
            'role'          => 'user',
            'date_of_birth' => '1995-06-15',
        ]);

        User::create([
            'name'          => 'Jane Smith',
            'email'         => 'jane@example.com',
            'password'      => Hash::make('password'),
            'role'          => 'user',
            'date_of_birth' => '1998-03-22',
        ]);
    }
}
