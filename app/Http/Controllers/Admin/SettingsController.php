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
        // Basic counts
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

        // Application status breakdown
        $applicationStats = [
            'pending' => \App\Models\BidderApplication::where('status', 'pending')->count(),
            'payment_verified' => \App\Models\BidderApplication::where('status', 'payment_verified')->count(),
            'invitation_sent' => \App\Models\BidderApplication::where('status', 'invitation_sent')->count(),
            'approved' => \App\Models\BidderApplication::where('status', 'approved')->count(),
            'rejected' => \App\Models\BidderApplication::where('status', 'rejected')->count(),
        ];

        // Recent activity (last 7 days)
        $recentActivity = [
            'new_applications' => \App\Models\BidderApplication::where('created_at', '>=', now()->subDays(7))->count(),
            'verified_payments' => \App\Models\BidderApplication::where('payment_verified_at', '>=', now()->subDays(7))->count(),
            'sent_invitations' => \App\Models\BidderApplication::where('invitation_sent_at', '>=', now()->subDays(7))->count(),
            'approved_applications' => \App\Models\BidderApplication::where('approved_at', '>=', now()->subDays(7))->count(),
            'new_bidders' => \App\Models\User::where('role', 'bidder')->where('updated_at', '>=', now()->subDays(7))->count(),
            'new_auctions' => \App\Models\Auction::where('created_at', '>=', now()->subDays(7))->count(),
            'new_bids' => \App\Models\Bid::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        // Monthly trends (last 6 months)
        $monthlyTrends = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyTrends[] = [
                'month' => $month->format('M Y'),
                'applications' => \App\Models\BidderApplication::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)->count(),
                'approved' => \App\Models\BidderApplication::whereYear('approved_at', $month->year)
                    ->whereMonth('approved_at', $month->month)->count(),
                'revenue' => \App\Models\BidderApplication::whereYear('approved_at', $month->year)
                    ->whereMonth('approved_at', $month->month)->sum('deposit_amount'),
            ];
        }

        // Pending actions for admin
        $pendingActions = [
            'applications_to_verify' => \App\Models\BidderApplication::where('status', 'pending')->count(),
            'applications_to_invite' => \App\Models\BidderApplication::where('status', 'payment_verified')->count(),
            'applications_to_approve' => \App\Models\BidderApplication::where('status', 'invitation_sent')->count(),
        ];

        // System health metrics
        $systemHealth = [
            'avg_application_processing_time' => $this->calculateAverageProcessingTime(),
            'conversion_rate' => $this->calculateConversionRate(),
            'revenue_per_application' => $stats['total_applications'] > 0 ? $stats['total_revenue'] / $stats['total_applications'] : 0,
        ];

        return view('admin.settings.statistics', compact(
            'stats', 
            'applicationStats', 
            'recentActivity', 
            'monthlyTrends', 
            'pendingActions',
            'systemHealth'
        ));
    }

    /**
     * Calculate average processing time for applications.
     */
    private function calculateAverageProcessingTime()
    {
        $approvedApplications = \App\Models\BidderApplication::whereNotNull('approved_at')->get();
        
        if ($approvedApplications->isEmpty()) {
            return 0;
        }

        $totalDays = 0;
        foreach ($approvedApplications as $application) {
            $totalDays += $application->created_at->diffInDays($application->approved_at);
        }

        return round($totalDays / $approvedApplications->count(), 1);
    }

    /**
     * Calculate conversion rate (applications to approved).
     */
    private function calculateConversionRate()
    {
        $totalApplications = \App\Models\BidderApplication::count();
        $approvedApplications = \App\Models\BidderApplication::where('status', 'approved')->count();
        
        if ($totalApplications === 0) {
            return 0;
        }

        return round(($approvedApplications / $totalApplications) * 100, 1);
    }
} 