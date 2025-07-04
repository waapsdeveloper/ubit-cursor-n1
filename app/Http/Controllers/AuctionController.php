<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;

class AuctionController extends Controller
{
    public function index()
    {
        // Fetch 3 featured/active auctions for the slider
        $auctions = Auction::where('status', 'active')->latest('start_time')->take(3)->get();
        return view('landing', compact('auctions'));
    }
}
