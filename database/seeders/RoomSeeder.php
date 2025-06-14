<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $hotels = Hotel::pluck('id')->toArray();

        foreach($hotels as $hotel)
        {
            for($i = 0; $i < 3; $i++){
                Room::create([
                    'hotel_id' => $hotel,
                    'name' => $faker->word,
                    'price' => $faker->randomFloat(2, 50, 500),
                    'description' => $faker->sentence,
                    'capacity' => $faker->numberBetween(1, 5),
                ]);
            }
        }
    }
}
