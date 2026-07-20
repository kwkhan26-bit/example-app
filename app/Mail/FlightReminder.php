<?php

namespace App\Mail;

use App\Models\Flight;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FlightReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $flight;

    public function __construct(Flight $flight)
    {
        $this->flight = $flight;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder: Your Upcoming Flight Details',
        );
    }

    public function content(): Content
    {
        
        return new Content(
            htmlString: "<h1>Flight Reminder</h1><p>Your flight <strong>{$this->flight->number}</strong> from {$this->flight->departure_city} to {$this->flight->arrival_city} is departing in exactly 24 hours.</p>"
        );
    }
}