<?php

namespace Database\Seeders;

use App\Models\Hotel;
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

        for($i = 0; $i < 10; $i++){
            Hotel::create([
                ''
            ]);
        }
    }
}
