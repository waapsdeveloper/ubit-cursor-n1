<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     */
    public function index()
    {
        $settings = [
            'deposit_amount' => config('auction.deposit_amount', 50000),
            'bank_name' => config('auction.bank_details.name', 'HBL Bank'),
            'account_title' => config('auction.bank_details.account_title', 'Sahil e Firdaus Auctions'),
            'account_number' => config('auction.bank_details.account_number', '1234-5678-9012-3456'),
            'default_bid_increment' => config('auction.default_bid_increment', 10000),
            'max_bid_amount' => config('auction.max_bid_amount', 999999999),
            'application_review_time' => config('auction.application_review_time', 48),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'deposit_amount' => 'required|numeric|min:1000',
            'bank_name' => 'required|string|max:100',
            'account_title' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'default_bid_increment' => 'required|numeric|min:1000',
            'max_bid_amount' => 'required|numeric|min:100000',
            'application_review_time' => 'required|numeric|min:1|max:168',
        ]);

        // Update environment variables (you might want to use a settings table instead)
        $this->updateEnvFile('AUCTION_DEPOSIT_AMOUNT', $request->deposit_amount);
        $this->updateEnvFile('AUCTION_BANK_NAME', $request->bank_name);
        $this->updateEnvFile('AUCTION_ACCOUNT_TITLE', $request->account_title);
        $this->updateEnvFile('AUCTION_ACCOUNT_NUMBER', $request->account_number);
        $this->updateEnvFile('AUCTION_DEFAULT_BID_INCREMENT', $request->default_bid_increment);
        $this->updateEnvFile('AUCTION_MAX_BID_AMOUNT', $request->max_bid_amount);
        $this->updateEnvFile('AUCTION_APPLICATION_REVIEW_TIME', $request->application_review_time);

        // Clear config cache
        Cache::forget('config');
        
        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Update environment file.
     */
    private function updateEnvFile($key, $value)
    {
        $path = base_path('.env');
        
        if (file_exists($path)) {
            $content = file_get_contents($path);
            
            // Check if key exists
            if (strpos($content, $key . '=') !== false) {
                // Update existing key
                $content = preg_replace(
                    '/^' . $key . '=.*/m',
                    $key . '=' . $value,
                    $content
                );
            } else {
                // Add new key
                $content .= "\n" . $key . '=' . $value;
            }
            
            file_put_contents($path, $content);
        }
    }

    /**
     * Show system statistics.
     */
    public function statistics()
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_bidders' => \App\Models\User::where('role', 'bidder')->count(),
            'total_applications' => \App\Models\BidderApplication::count(),
            'pending_applications' => \App\Models\BidderApplication::where('status', 'pending')->count(),
            'total_auctions' => \App\Models\Auction::count(),
            'active_auctions' => \App\Models\Auction::where('status', 'active')->count(),
            'total_bids' => \App\Models\Bid::count(),
            'total_revenue' => \App\Models\BidderApplication::where('status', 'approved')->sum('deposit_amount'),
        ];

        return view('admin.settings.statistics', compact('stats'));
    }
} 