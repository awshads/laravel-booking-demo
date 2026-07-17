<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Facility;
use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'test@example.com',
            'password'=> bcrypt('123456'),
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password'=> bcrypt('123456'),
            'role' => 'staff'
        ]);

        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password'=> bcrypt('123456'),
            'role' => 'user'
        ]);

        Facility::factory(30)->create();

        Booking::factory(10)->create();
    }
}
