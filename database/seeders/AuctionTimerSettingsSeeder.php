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
        $timerStyles = ['compact', 'detailed', 'minimal'];
        $timerColors = ['orange', 'red', 'green', 'purple'];

        foreach ($auctions as $index => $auction) {
            // Check if timer settings already exist
            if (!$auction->timerSettings) {
                // Create varied timer configurations
                $style = $timerStyles[$index % count($timerStyles)];
                $color = $timerColors[$index % count($timerColors)];
                
                // Vary the warning thresholds
                $warningThresholds = [1800, 3600, 7200]; // 30 min, 1 hour, 2 hours
                $warningThreshold = $warningThresholds[$index % count($warningThresholds)];
                
                // Vary refresh intervals
                $refreshIntervals = [1000, 2000, 5000]; // 1s, 2s, 5s
                $refreshInterval = $refreshIntervals[$index % count($refreshIntervals)];

                AuctionTimerSetting::create([
                    'auction_id' => $auction->id,
                    'show_timer' => true,
                    'show_days' => true,
                    'show_hours' => true,
                    'show_minutes' => true,
                    'show_seconds' => $style !== 'minimal', // Hide seconds for minimal style
                    'timer_style' => $style,
                    'timer_color' => $color,
                    'auto_refresh' => true,
                    'refresh_interval' => $refreshInterval,
                    'expired_message' => $this->getExpiredMessage($color),
                    'show_warning' => true,
                    'warning_threshold' => $warningThreshold,
                ]);
            }
        }
    }

    /**
     * Get different expired messages based on color theme
     */
    private function getExpiredMessage(string $color): string
    {
        $messages = [
            'orange' => 'Auction Ended',
            'red' => 'Bidding Closed',
            'green' => 'Time\'s Up',
            'purple' => 'Auction Complete'
        ];

        return $messages[$color] ?? 'Auction Ended';
    }
}
