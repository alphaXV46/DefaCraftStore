<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin DefaCraft',
            'email' => 'admin@defacraft.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => Hash::make('user123'),
            'role' => 'user'
        ]);
    }
}