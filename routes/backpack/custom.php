<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('auction', 'AuctionCrudController');
    Route::crud('bid', 'BidCrudController');
    Route::crud('wallet', 'WalletCrudController');
    Route::crud('invite', 'InviteCrudController');
    Route::crud('auctiontimersetting', 'AuctiontimersettingCrudController');
    Route::crud('invitation', 'App\Http\Controllers\Admin\InvitationCrudController');
    Route::get('invitation/{id}/send-invite', [\App\Http\Controllers\Admin\InvitationCrudController::class, 'sendInvite'])->name('backpack.invitation.send_invite');
    Route::crud('bidder-application', 'BidderApplicationCrudController');
    Route::get('bidder-application/{id}/verify-payment', [\App\Http\Controllers\Admin\BidderApplicationCrudController::class, 'verifyPayment'])->name('backpack.bidder-application.verify-payment');
    Route::get('bidder-application/{id}/send-invitation', [\App\Http\Controllers\Admin\BidderApplicationCrudController::class, 'sendInvitation'])->name('backpack.bidder-application.send-invitation');
    Route::get('bidder-application/{id}/approve', [\App\Http\Controllers\Admin\BidderApplicationCrudController::class, 'approve'])->name('backpack.bidder-application.approve');

}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
