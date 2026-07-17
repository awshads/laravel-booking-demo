<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
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
        return [
            'facility_id' => Facility::all()->random()->id,
            'booked_at' => now(),
            'booked_by_id' => User::all()->random()->id,
            'status' => 'pending',
        ];
    }
}
