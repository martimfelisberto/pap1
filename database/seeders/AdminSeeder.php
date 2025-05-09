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
            'name' => 'Admin',
            'email' => 'admin@reshopping.pt',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        User::where('email', 'admin@reshopping.pt')->first()->update(['is_admin' => true]);
        User::where('email', 'admin@reshopping.pt')->first()->is_admin;
    }
}