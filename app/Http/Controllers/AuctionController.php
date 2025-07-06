<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;

class AuctionController extends Controller
{
    public function index()
    {
        $featuredProperties = Auction::with('timerSettings')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(9)
            ->get();

        return view('landing', compact('featuredProperties'));
    }

    public function list(Request $request)
    {
        $query = Auction::with('timerSettings')->where('status', 'active');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('starting_bid', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('starting_bid', '<=', $request->max_price);
        }

        // Sort options
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('starting_bid', 'asc');
                break;
            case 'price_high':
                $query->orderBy('starting_bid', 'desc');
                break;
            case 'ending_soon':
                $query->orderBy('end_time', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $auctions = $query->paginate(12);

        return view('auctions.list', compact('auctions'));
    }

    public function showBidForm($id)
    {
        $auction = Auction::with(['timerSettings', 'bids.user'])->findOrFail($id);
        
        // Check if auction is still active
        if ($auction->status !== 'active') {
            return redirect()->route('auction.detail', $id)
                ->with('error', 'This auction is no longer active.');
        }

        // Check if auction has ended
        if (now()->gt($auction->end_time)) {
            return redirect()->route('auction.detail', $id)
                ->with('error', 'This auction has ended.');
        }

        // Get current highest bid
        $currentBid = $auction->bids()->orderBy('amount', 'desc')->first();
        $currentAmount = $currentBid ? $currentBid->amount : $auction->starting_bid;
        
        // Calculate minimum next bid
        $minNextBid = $currentAmount + $auction->bid_increment;
        
        // Get recent bid history (last 10 bids)
        $recentBids = $auction->bids()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->reverse();

        // Check if user is authenticated
        $user = auth()->user();
        $canBid = $user && $user->id !== $auction->created_by; // Can't bid on your own auction

        return view('auctions.bid', compact(
            'auction', 
            'currentBid', 
            'currentAmount', 
            'minNextBid', 
            'recentBids', 
            'canBid',
            'user'
        ));
    }
}
