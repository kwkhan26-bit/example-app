<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Flight;
use Illuminate\Support\Facades\Mail;
use App\Mail\FlightReminder;

class SendFlightReminders extends Command
{
    // The terminal command signature
    protected $signature = 'app:send-flight-reminders';

    protected $description = 'Send reminder emails to passengers 24 hours before flight departure';

    public function handle()
    {
        // Get the exact time 24 hours from right now
        $targetTime = now()->addHours(24);

        // Find flights departing in that exact minute
        $flights = Flight::with('passengers')
            ->whereBetween('departure_time', [
                $targetTime->copy()->startOfMinute(),
                $targetTime->copy()->endOfMinute()
            ])->get();

        foreach ($flights as $flight) {
            foreach ($flight->passengers as $passenger) {
                // Send the email to the passenger
                Mail::to($passenger->email)->send(new FlightReminder($flight));
            }
        }

        $this->info('Flight reminders processed successfully.');
    }
}