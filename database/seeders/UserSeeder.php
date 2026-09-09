<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ],
            [
                'name' => 'Loan Officer',
                'email' => 'officer@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'loan_officer',
            ],
            [
                'name' => 'Cashier User',
                'email' => 'cashier@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'cashier',
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'customer',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}