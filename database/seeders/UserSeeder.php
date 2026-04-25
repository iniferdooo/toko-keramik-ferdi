<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name'     => 'Admin Ferdi',
            'email'    => 'admin@tokokeramik.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
            'phone'    => '081234567890',
            'address'  => 'Jl. Keramik No. 1, Malang',
        ]);

        // Akun Customer Contoh
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'customer',
            'phone'    => '082345678901',
            'address'  => 'Jl. Mawar No. 5, Malang',
        ]);

        User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'customer',
            'phone'    => '083456789012',
            'address'  => 'Jl. Melati No. 10, Malang',
        ]);
    }
}