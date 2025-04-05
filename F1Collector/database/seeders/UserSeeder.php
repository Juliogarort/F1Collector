<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('f1collector_users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin1234'),
                'user_type' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cliente Normal',
                'email' => 'cliente@example.com',
                'password' => Hash::make('cliente1234'),
                'user_type' => 'Customer',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
