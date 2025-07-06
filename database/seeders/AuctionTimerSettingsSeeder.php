<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\AuctionTimerSetting;
use Illuminate\Database\Seeder;

class AuctionTimerSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auctions = Auction::all();

        foreach ($auctions as $auction) {
            // Check if timer settings already exist
            if (!$auction->timerSettings) {
                AuctionTimerSetting::create([
                    'auction_id' => $auction->id,
                    'show_timer' => true,
                    'show_days' => true,
                    'show_hours' => true,
                    'show_minutes' => true,
                    'show_seconds' => true,
                    'timer_style' => 'compact',
                    'timer_color' => 'orange',
                    'auto_refresh' => true,
                    'refresh_interval' => 1000,
                    'expired_message' => 'Auction Ended',
                    'show_warning' => true,
                    'warning_threshold' => 3600, // 1 hour
                ]);
            }
        }
    }
}
