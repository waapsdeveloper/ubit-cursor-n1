<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AuctionDetailController;
use App\Http\Controllers\BidderApplicationController;

Route::get('/', [AuctionController::class, 'index'])->name('landing');
Route::get('/auctions', [AuctionController::class, 'list'])->name('auctions.list');
Route::get('/auction/{id}', [AuctionDetailController::class, 'show'])->name('auction.detail');
Route::get('/auction/{id}/bid', [AuctionController::class, 'showBidForm'])->name('auction.bid');
Route::post('/auction/{id}/bid', [AuctionController::class, 'submitBid'])->name('auction.bid.submit');

// Bidder Application Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/bidder-application', [BidderApplicationController::class, 'show'])->name('bidder.application.show');
    Route::post('/bidder-application', [BidderApplicationController::class, 'submit'])->name('bidder.application.submit');
    Route::get('/bidder-application/status', [BidderApplicationController::class, 'status'])->name('bidder.application.status');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
