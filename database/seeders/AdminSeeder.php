<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@reshopping.pt',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_admin' => true
        ]);
    }
}