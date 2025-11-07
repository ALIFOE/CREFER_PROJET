<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'conceptart228@gmail.com',
            'password' => Hash::make('azerty1234'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}