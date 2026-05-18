<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Superadmin
        User::updateOrCreate(
            ['email' => 'superadmin@defacraft.com'],
            [
                'name' => 'Super Admin DefaCraft',
                'password' => Hash::make('superadmin123'),
                'role' => 'superadmin',
                'nomor_wa' => '081122334455',
            ]
        );

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@defacraft.com'],
            [
                'name' => 'Admin DefaCraft',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'nomor_wa' => '081234567890',
            ]
        );

        // User Test
        User::updateOrCreate(
            ['email' => 'user@test.com'],
            [
                'name' => 'User Test',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'nomor_wa' => '089876543210',
            ]
        );
    }
}