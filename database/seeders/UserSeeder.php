<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'marinos',
            'email' => 'marinos1366@gmail.com',
            'password' => 'asdf',
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);
    }
}
