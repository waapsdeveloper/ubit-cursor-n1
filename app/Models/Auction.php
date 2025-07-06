<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
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

    /**
     * Get the timer settings for the auction.
     */
    public function timerSettings(): HasOne
    {
        return $this->hasOne(AuctionTimerSetting::class);
    }

    /**
     * Get the time remaining until auction ends.
     */
    public function getTimeRemaining(): array
    {
        $now = now();
        $endTime = $this->end_time;
        
        if ($now >= $endTime) {
            return [
                'days' => 0,
                'hours' => 0,
                'minutes' => 0,
                'seconds' => 0,
                'total_seconds' => 0,
                'is_expired' => true
            ];
        }

        $diff = $endTime->diff($now);
        $totalSeconds = $endTime->diffInSeconds($now);

        return [
            'days' => $diff->days,
            'hours' => $diff->h,
            'minutes' => $diff->i,
            'seconds' => $diff->s,
            'total_seconds' => $totalSeconds,
            'is_expired' => false
        ];
    }
}
