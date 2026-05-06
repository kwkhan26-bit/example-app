<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Passenger;

class PassengerSeeder extends Seeder
{
    public function run(): void
    {
        Passenger::factory()->count(1000)->create();
    }
}