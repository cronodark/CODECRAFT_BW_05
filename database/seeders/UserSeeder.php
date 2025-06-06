<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
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
        User::create([
            'name' => 'admin1',
            'email' => 'admin1@email.com',
            'password' => Hash::make('admin1'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'admin2',
            'email' => 'admin2@email.com',
            'password' => Hash::make('admin2'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'user1',
            'email' => 'user1@email.com',
            'password' => Hash::make('user1'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'user2',
            'email' => 'user2@email.com',
            'password' => Hash::make('user2'),
            'role' => 'user',
        ]);
    }
}
