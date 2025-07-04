<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auction>
 */
class AuctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'image' => fake()->imageUrl(640, 480, 'house', true),
            'location' => fake()->address(),
            'starting_bid' => fake()->numberBetween(100000, 1000000),
            'deposit' => fake()->numberBetween(10000, 50000),
            'bid_increment' => fake()->numberBetween(1000, 10000),
            'start_time' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'end_time' => fake()->dateTimeBetween('+1 week', '+2 weeks'),
            'status' => fake()->randomElement(['pending', 'active', 'closed']),
            'created_by' => \App\Models\User::factory(['role' => 'admin']),
        ];
    }
}
