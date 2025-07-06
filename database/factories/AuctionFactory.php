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
        // Array of available property images
        $propertyImages = [
            'images/demo/properties/pr-1.png',
            'images/demo/properties/pr-2.png',
            'images/demo/properties/pr-3.png',
            'images/demo/properties/pr-4.png',
            'images/demo/properties/pr-5.png',
            'images/demo/properties/pr-6.png',
            'images/demo/properties/pr-7.png',
            'images/demo/properties/pr-8.png',
            'images/demo/properties/pr-9.png',
        ];

        // Property titles that match the images
        $propertyTitles = [
            'Luxury Villa with Ocean View',
            'Modern Downtown Apartment',
            'Beachfront Penthouse Suite',
            'Garden Villa with Pool',
            'Executive Townhouse',
            'Waterfront Luxury Home',
            'Mountain View Estate',
            'Urban Loft Apartment',
            'Seaside Villa Complex'
        ];

        // Property locations
        $propertyLocations = [
            'Sahil e Firdaus - Beachfront',
            'Sahil e Firdaus - Downtown',
            'Sahil e Firdaus - Ocean Drive',
            'Sahil e Firdaus - Garden District',
            'Sahil e Firdaus - Executive Heights',
            'Sahil e Firdaus - Waterfront',
            'Sahil e Firdaus - Mountain View',
            'Sahil e Firdaus - Urban Center',
            'Sahil e Firdaus - Coastal Resort'
        ];

        // Get a random index for consistent image/title/location pairing
        $index = fake()->numberBetween(0, 8);

        return [
            'title' => $propertyTitles[$index],
            'image' => $propertyImages[$index],
            'location' => $propertyLocations[$index],
            'starting_bid' => fake()->numberBetween(5000000, 50000000), // PKR 5M to 50M
            'deposit' => fake()->numberBetween(500000, 2000000), // PKR 500K to 2M deposit
            'bid_increment' => fake()->numberBetween(100000, 500000), // PKR 100K to 500K increments
            'start_time' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'end_time' => fake()->dateTimeBetween('+1 week', '+2 weeks'),
            'status' => fake()->randomElement(['pending', 'active', 'closed']),
            'created_by' => \App\Models\User::factory(['role' => 'admin']),
        ];
    }
}
