<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $users =  User::where('role', 'user')->pluck('id')->toArray();
        $rooms = Room::pluck('id')->toArray();

        foreach($users as $user){
            for($i = 0; $i < 2; $i++){
                $checkInDate = $faker->dateTimeBetween('now', '+1 month');
                $checkOutDate = (clone $checkInDate)->modify('+'.rand(1, 14).' days');

                Booking::create([
                    'user_id' => $user,
                    'room_id' => $faker->randomElement($rooms),
                    'check_in_date' => $checkInDate,
                    'check_out_date' => $checkOutDate,
                ]);
            }
        }
    }
}
