<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if(!User::count()) User::factory(20)->create();
        return [
            'id' => Str::uuid()->toString(),
            'user_id' => User::inRandomOrder()->first()->id,
            'vehicle_make' => $this->faker->words(3, true),
            'vehicle_model' => $this->faker->words(3, true),
            'booking_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'booking_time' => $this->faker->time('H:i'),
        ];
    }
}
