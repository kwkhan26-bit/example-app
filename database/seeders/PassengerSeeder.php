<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Passenger;
use App\Models\Flight;

class PassengerSeeder extends Seeder
{
    public function run(): void
    {
        // Create all 1000 passengers at once
        Passenger::factory()->count(1000)->create();

        // Get all flight IDs once
        $flightIds = Flight::pluck('id')->toArray();

        // Attach flights to each passenger in bulk
        Passenger::all()->each(function ($passenger) use ($flightIds) {
            $randomFlights = array_rand(array_flip($flightIds), rand(1, 3));
            $passenger->flights()->attach((array) $randomFlights);
        });
    }
}