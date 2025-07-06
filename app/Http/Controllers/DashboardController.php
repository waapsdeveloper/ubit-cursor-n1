<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's active bids (auctions they're currently bidding on)
        $activeBids = Bid::where('user_id', $user->id)
            ->with(['auction' => function($query) {
                $query->where('status', 'active');
            }])
            ->whereHas('auction', function($query) {
                $query->where('status', 'active');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('auction_id');

        // Get user's won auctions
        $wonAuctions = Auction::where('status', 'ended')
            ->whereHas('bids', function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->whereRaw('amount = (SELECT MAX(amount) FROM bids WHERE auction_id = auctions.id)');
            })
            ->with(['bids' => function($query) {
                $query->orderBy('amount', 'desc');
            }])
            ->get();

        // Get user's created auctions
        $createdAuctions = Auction::where('created_by', $user->id)
            ->with(['bids' => function($query) {
                $query->orderBy('amount', 'desc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get recent bid history
        $recentBids = Bid::where('user_id', $user->id)
            ->with(['auction'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Calculate statistics
        $totalBidsPlaced = Bid::where('user_id', $user->id)->count();
        $totalAuctionsWon = $wonAuctions->count();
        $totalAuctionsCreated = $createdAuctions->count();
        $totalBidAmount = Bid::where('user_id', $user->id)->sum('amount');

        // Get current highest bids by user
        $currentHighestBids = Bid::where('user_id', $user->id)
            ->whereHas('auction', function($query) {
                $query->where('status', 'active');
            })
            ->with(['auction'])
            ->get()
            ->filter(function($bid) {
                return $bid->amount === $bid->auction->bids()->max('amount');
            });

        return view('dashboard', compact(
            'user',
            'activeBids',
            'wonAuctions',
            'createdAuctions',
            'recentBids',
            'totalBidsPlaced',
            'totalAuctionsWon',
            'totalAuctionsCreated',
            'totalBidAmount',
            'currentHighestBids'
        ));
    }
} 