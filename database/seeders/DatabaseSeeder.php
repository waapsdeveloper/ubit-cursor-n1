<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Bid;
use App\Models\Wallet;
use App\Models\Invite;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 3 admins and 15 bidders
        $admins = User::factory(3)->create(['role' => 'admin']);
        $bidders = User::factory(15)->create(['role' => 'bidder']);

        // Create wallets for all users
        $admins->each(fn($admin) => Wallet::factory()->create(['user_id' => $admin->id]));
        $bidders->each(fn($bidder) => Wallet::factory()->create(['user_id' => $bidder->id]));

        // Seed auctions with actual property images
        $this->call(AuctionSeeder::class);
        
        // Seed timer settings for auctions
        $this->call(AuctionTimerSettingsSeeder::class);

        // Get the created auctions for bidding
        $auctions = \App\Models\Auction::all();

        // Create 50 bids, each by a random bidder on a random auction
        foreach (range(1, 50) as $i) {
            Bid::factory()->create([
                'user_id' => $bidders->random()->id,
                'auction_id' => $auctions->random()->id,
                'amount' => fake()->numberBetween(100000, 1000000),
            ]);
        }

        // Create 10 invites, each by a random admin
        foreach (range(1, 10) as $i) {
            Invite::factory()->create([
                'invited_by' => $admins->random()->id,
            ]);
        }

        // Seed the super admin
        $this->call(SuperAdminSeeder::class);
    }
}
