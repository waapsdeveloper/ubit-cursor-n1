<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Bid; // Added this import for the new method

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

    public function submitBid(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);
        $user = auth()->user();

        // Validation checks
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to place a bid.');
        }

        // Check if user has bidder role
        if (!$user->isBidder()) {
            return redirect()->route('bidder.application.show')
                ->with('error', 'You need to become a bidder to place bids. Please complete the application process.');
        }

        if ($user->id === $auction->created_by) {
            return redirect()->route('auction.bid', $id)
                ->with('error', 'You cannot bid on your own auction.');
        }

        if ($auction->status !== 'active') {
            return redirect()->route('auction.detail', $id)
                ->with('error', 'This auction is no longer active.');
        }

        if (now()->gt($auction->end_time)) {
            return redirect()->route('auction.detail', $id)
                ->with('error', 'This auction has ended.');
        }

        // Get current highest bid
        $currentBid = $auction->bids()->orderBy('amount', 'desc')->first();
        $currentAmount = $currentBid ? $currentBid->amount : $auction->starting_bid;
        $minNextBid = $currentAmount + $auction->bid_increment;

        // Validate bid amount
        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:' . $minNextBid,
                'max:999999999'
            ],
            'agree_terms' => 'required|accepted'
        ], [
            'amount.min' => 'Your bid must be at least PKR ' . number_format($minNextBid, 0) . '.',
            'amount.max' => 'Bid amount is too high.',
            'agree_terms.required' => 'You must agree to the terms and conditions.'
        ]);

        // Check if user already has the highest bid
        if ($currentBid && $currentBid->user_id === $user->id) {
            return redirect()->route('auction.bid', $id)
                ->with('error', 'You already have the highest bid on this auction.');
        }

        try {
            // Create the bid
            $bid = Bid::create([
                'user_id' => $user->id,
                'auction_id' => $auction->id,
                'amount' => $request->amount
            ]);

            // Redirect with success message
            return redirect()->route('auction.detail', $id)
                ->with('success', 'Your bid of PKR ' . number_format($request->amount, 0) . ' has been placed successfully!');

        } catch (\Exception $e) {
            return redirect()->route('auction.bid', $id)
                ->with('error', 'There was an error placing your bid. Please try again.');
        }
    }
}
