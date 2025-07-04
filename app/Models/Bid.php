<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'auction_id',
        'amount',
    ];

    /**
     * Get the user who placed the bid.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the auction for the bid.
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
}
