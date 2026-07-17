<?php

namespace Database\Factories;

use App\Models\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Facility>
 */
class FacilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->country(),
            'description' => fake()->sentence(),
            'type' => 'meetingRoom',
            'capacity' => fake()->numberBetween(1, 100),
            'location' => fake()->city(),
        ];
    }
}
