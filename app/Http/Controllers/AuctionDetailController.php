<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;

class AuctionDetailController extends Controller
{
    public function show($id)
    {
        $auction = Auction::with(['bids.user', 'timerSettings', 'creator'])
            ->findOrFail($id);
        
        // Get current highest bid
        $currentBid = $auction->bids()->orderBy('amount', 'desc')->first();
        
        // Get bid history
        $bidHistory = $auction->bids()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Get related auctions (same category or similar price range)
        $relatedAuctions = Auction::where('id', '!=', $auction->id)
            ->where('status', 'active')
            ->inRandomOrder()
            ->take(4)
            ->get();
        
        // Calculate view count (simulated for now)
        $viewCount = rand(100, 500);
        
        return view('auctions.detail', compact(
            'auction',
            'currentBid',
            'bidHistory',
            'relatedAuctions',
            'viewCount'
        ));
    }
}
