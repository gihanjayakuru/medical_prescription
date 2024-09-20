<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Pharmacy User',
            'email' => 'pharmacy@example.com',
            'password' => Hash::make('password'),
            'role' => 'pharmacy',
            'address' => 'Pharmacy Address',
            'contact_no' => '1234567890',
            'dob' => '1985-01-01',
        ]);

        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'address' => 'User Address',
            'contact_no' => '0987654321',
            'dob' => '1990-01-01',
        ]);
    }
}
