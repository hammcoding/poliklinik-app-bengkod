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
        // nama, email, password, role
        $users = [
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'no_hp' => '00876567788',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ],
            [
                'nama' => 'Dokter',
                'email' => 'dokter@gmail.com',
                'no_hp' => '00876567788',
                'password' => Hash::make('dokter'),
                'role' => 'dokter',
            ],
            [
                'nama' => 'Pasien',
                'email' => 'pasien@gmail.com',
                'no_hp' => '00876567788',
                'password' => Hash::make('pasien'),
                'role' => 'pasien',
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}