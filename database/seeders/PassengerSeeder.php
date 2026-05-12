<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Passenger;
use App\Models\Flight;

class PassengerSeeder extends Seeder
{
    public function run(): void
    {
        Passenger::factory()->count(1000)->create()->each(function ($passenger) {
            $flights = Flight::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $passenger->flights()->attach($flights);
        });
    }
}