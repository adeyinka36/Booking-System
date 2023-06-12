<?php

namespace App\Listeners;

use App\Events\BookingMade;
use App\Jobs\SendEmailToAdminAndClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BookingMadeListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingMade $event): void
    {
        $booking  = $event->booking;

        //send email to admin and customer
        SendEmailToAdminAndClient::dispatch($booking);

    }
}
