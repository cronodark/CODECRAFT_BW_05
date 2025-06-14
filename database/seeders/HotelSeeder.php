<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $users = User::where('role', 'admin')->pluck('id')->toArray();

        for($i = 0; $i < 4; $i++){
            Hotel::create([
                'name' => $faker->company,
                'location' => $faker->address,
                'owner_id' => $faker->randomElement($users),
            ]);
        }
    }
}
