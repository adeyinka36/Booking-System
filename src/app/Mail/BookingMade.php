<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingMade extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     */
    public function __construct(private readonly Booking $booking)
    {

    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('emails.admin_email'),
            to: config('emails.server_email'),
            subject: 'Your Booking Reservation Has Been Made'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking_made',
            with: [
                'booking' => $this->booking
            ]
        );
    }

}
