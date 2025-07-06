<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Auction Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration settings for the auction system.
    |
    */

    // Deposit amount required for bidder applications (in PKR)
    'deposit_amount' => env('AUCTION_DEPOSIT_AMOUNT', 50000),

    // Bank account details for deposits
    'bank_details' => [
        'name' => env('AUCTION_BANK_NAME', 'HBL Bank'),
        'account_title' => env('AUCTION_ACCOUNT_TITLE', 'Sahil e Firdaus Auctions'),
        'account_number' => env('AUCTION_ACCOUNT_NUMBER', '1234-5678-9012-3456'),
    ],

    // Default bid increment (in PKR)
    'default_bid_increment' => env('AUCTION_DEFAULT_BID_INCREMENT', 10000),

    // Maximum bid amount (in PKR)
    'max_bid_amount' => env('AUCTION_MAX_BID_AMOUNT', 999999999),

    // Application review time (in hours)
    'application_review_time' => env('AUCTION_APPLICATION_REVIEW_TIME', 48),
]; 