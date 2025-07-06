<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Database\Seeder;

class AuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin users
        $admins = User::where('role', 'admin')->get();
        
        if ($admins->isEmpty()) {
            // Create an admin if none exists
            $admin = User::factory()->create(['role' => 'admin']);
        } else {
            $admin = $admins->first();
        }

        // Property data with actual images
        $properties = [
            [
                'title' => 'Luxury Villa with Ocean View',
                'image' => 'images/demo/properties/pr-1.png',
                'location' => 'Sahil e Firdaus - Beachfront',
                'starting_bid' => 25000000,
                'deposit' => 1000000,
                'bid_increment' => 200000,
                'start_time' => now()->addDays(2),
                'end_time' => now()->addDays(9),
                'status' => 'active',
            ],
            [
                'title' => 'Modern Downtown Apartment',
                'image' => 'images/demo/properties/pr-2.png',
                'location' => 'Sahil e Firdaus - Downtown',
                'starting_bid' => 18000000,
                'deposit' => 800000,
                'bid_increment' => 150000,
                'start_time' => now()->addDays(1),
                'end_time' => now()->addDays(8),
                'status' => 'active',
            ],
            [
                'title' => 'Beachfront Penthouse Suite',
                'image' => 'images/demo/properties/pr-3.png',
                'location' => 'Sahil e Firdaus - Ocean Drive',
                'starting_bid' => 35000000,
                'deposit' => 1500000,
                'bid_increment' => 300000,
                'start_time' => now()->addDays(3),
                'end_time' => now()->addDays(10),
                'status' => 'active',
            ],
            [
                'title' => 'Garden Villa with Pool',
                'image' => 'images/demo/properties/pr-4.png',
                'location' => 'Sahil e Firdaus - Garden District',
                'starting_bid' => 22000000,
                'deposit' => 900000,
                'bid_increment' => 180000,
                'start_time' => now()->addDays(4),
                'end_time' => now()->addDays(11),
                'status' => 'active',
            ],
            [
                'title' => 'Executive Townhouse',
                'image' => 'images/demo/properties/pr-5.png',
                'location' => 'Sahil e Firdaus - Executive Heights',
                'starting_bid' => 28000000,
                'deposit' => 1200000,
                'bid_increment' => 250000,
                'start_time' => now()->addDays(5),
                'end_time' => now()->addDays(12),
                'status' => 'active',
            ],
            [
                'title' => 'Waterfront Luxury Home',
                'image' => 'images/demo/properties/pr-6.png',
                'location' => 'Sahil e Firdaus - Waterfront',
                'starting_bid' => 42000000,
                'deposit' => 1800000,
                'bid_increment' => 400000,
                'start_time' => now()->addDays(6),
                'end_time' => now()->addDays(13),
                'status' => 'active',
            ],
            [
                'title' => 'Mountain View Estate',
                'image' => 'images/demo/properties/pr-7.png',
                'location' => 'Sahil e Firdaus - Mountain View',
                'starting_bid' => 38000000,
                'deposit' => 1600000,
                'bid_increment' => 350000,
                'start_time' => now()->addDays(7),
                'end_time' => now()->addDays(14),
                'status' => 'active',
            ],
            [
                'title' => 'Urban Loft Apartment',
                'image' => 'images/demo/properties/pr-8.png',
                'location' => 'Sahil e Firdaus - Urban Center',
                'starting_bid' => 15000000,
                'deposit' => 600000,
                'bid_increment' => 120000,
                'start_time' => now()->addDays(8),
                'end_time' => now()->addDays(15),
                'status' => 'active',
            ],
            [
                'title' => 'Seaside Villa Complex',
                'image' => 'images/demo/properties/pr-9.png',
                'location' => 'Sahil e Firdaus - Coastal Resort',
                'starting_bid' => 45000000,
                'deposit' => 2000000,
                'bid_increment' => 450000,
                'start_time' => now()->addDays(9),
                'end_time' => now()->addDays(16),
                'status' => 'active',
            ],
            // Add some auctions ending soon for timer testing
            [
                'title' => 'Quick Sale Apartment',
                'image' => 'images/demo/properties/pr-1.png',
                'location' => 'Sahil e Firdaus - Quick Sale',
                'starting_bid' => 12000000,
                'deposit' => 500000,
                'bid_increment' => 100000,
                'start_time' => now()->subDays(2),
                'end_time' => now()->addHours(2), // Ends in 2 hours
                'status' => 'active',
            ],
            [
                'title' => 'Last Minute Villa',
                'image' => 'images/demo/properties/pr-2.png',
                'location' => 'Sahil e Firdaus - Last Minute',
                'starting_bid' => 20000000,
                'deposit' => 800000,
                'bid_increment' => 150000,
                'start_time' => now()->subDays(1),
                'end_time' => now()->addMinutes(30), // Ends in 30 minutes
                'status' => 'active',
            ],
        ];

        // Create auctions
        foreach ($properties as $property) {
            Auction::create([
                ...$property,
                'created_by' => $admin->id,
            ]);
        }
    }
} 