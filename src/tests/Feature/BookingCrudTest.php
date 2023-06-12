<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testCanRetrieveBookings()
    {
        $this->withoutMiddleware();
        $user = \App\Models\Booking::factory(1)->create();
        \App\Models\Booking::factory(10)->create()->each(function ($booking) use ($user) {
            $booking->user()->associate($user);
        });

        $response = $this->get('/api/v1/bookings');


        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'vehicle_make',
                    'vehicle_model',
                    'booking_time',
                    'booking_date',
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'phone_number',
                    ],
                ],
            ],
        ]);
    }

    public function testCanCreateBooking()
    {
        $this->withoutMiddleware();

        $user = \App\Models\User::factory(1)->create()[0];

        $bookingData = [
            'user_id' => $user->id,
            'vehicle_make' => 'Toyota Camry',
            'vehicle_model' => '2021',
            'booking_time' => '09:30',
            'booking_date' => '2023-06-20',
        ];

        $response = $this->post('/api/v1/bookings', $bookingData);

        $response->assertStatus(201);

        // And we should see the booking in the database
        $response->assertJsonStructure([
            'data' => [
                'id',
                'vehicle_make',
                'vehicle_model',
                'booking_time',
                'booking_date',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'phone_number',
                ],
            ],
        ]);
    }

    public function testCanShowBooking()
    {
        $this->withoutMiddleware();
        // Given we have a booking in the database
        $booking = \App\Models\Booking::factory(1)->create()[0];

        // When we get the booking's endpoint
        $response = $this->get("/api/v1/bookings/{$booking->id}");

        // Then we should receive a 200 OK response
        $response->assertStatus(200);

        // And we should see the booking data in the response
        $response->assertJsonStructure([
            'data' => [
                'id',
                'vehicle_make',
                'vehicle_model',
                'booking_time',
                'booking_date',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'phone_number',
                ],
            ],
        ]);
    }

    public function testCanUpdateBooking()
    {
        $this->withoutMiddleware();
        // Given we have a booking in the database
        $booking = \App\Models\Booking::factory(1)->create()[0];

        // And we have some updated booking data
        $updatedBookingData = [
            'vehicle_make' => 'Toyota Camry',
            'vehicle_model' => '2021',
            'booking_time' => '11:30',
            'booking_date' => '2023-06-21',
        ];

        // When we put to the booking's endpoint
        $response = $this->put("/api/v1/bookings/{$booking->id}", $updatedBookingData);

        // Then we should receive a 200 OK response
        $response->assertStatus(200);

        // And we should see the updated booking data in the database
        $updated = \App\Models\Booking::find($booking->id);

        $this->assertEquals('Toyota Camry', $updated->vehicle_make);
        $this->assertEquals('2021', $updated->vehicle_model);
        $this->assertEquals('11:30', $updated->booking_time);
        $this->assertEquals('2023-06-21', $updated->booking_date);

    }

    public function testCanDeleteBooking()
    {
        $this->withoutMiddleware();

        $booking = \App\Models\Booking::factory(1)->create()[0];

        $response = $this->delete("/api/v1/bookings/{$booking->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('bookings', $booking->toArray());
    }
}
