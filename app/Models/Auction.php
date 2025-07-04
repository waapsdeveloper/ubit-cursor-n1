<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'location',
        'starting_bid',
        'deposit',
        'bid_increment',
        'start_time',
        'end_time',
        'status',
        'created_by',
    ];

    /**
     * Get the admin who created the auction.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the bids for the auction.
     */
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}
