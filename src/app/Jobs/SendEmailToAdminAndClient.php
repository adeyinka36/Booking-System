<?php

namespace App\Jobs;

use App\Mail\BookingMade;
use App\Mail\BookingReceived;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailToAdminAndClient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Booking $booking)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::send(new BookingMade($this->booking));
        Mail::send(new BookingReceived($this->booking));
    }
}
