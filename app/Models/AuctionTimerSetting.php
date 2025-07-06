<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuctionTimerSetting extends Model
{
    use CrudTrait;
    protected $fillable = [
        'auction_id',
        'show_timer',
        'show_days',
        'show_hours',
        'show_minutes',
        'show_seconds',
        'timer_style',
        'timer_color',
        'auto_refresh',
        'refresh_interval',
        'expired_message',
        'show_warning',
        'warning_threshold',
    ];

    protected $casts = [
        'show_timer' => 'boolean',
        'show_days' => 'boolean',
        'show_hours' => 'boolean',
        'show_minutes' => 'boolean',
        'show_seconds' => 'boolean',
        'auto_refresh' => 'boolean',
        'show_warning' => 'boolean',
    ];

    /**
     * Get the auction that owns the timer setting.
     */
    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class);
    }

    /**
     * Get the timer configuration as JSON for JavaScript.
     */
    public function getTimerConfig(): array
    {
        return [
            'showTimer' => $this->show_timer,
            'showDays' => $this->show_days,
            'showHours' => $this->show_hours,
            'showMinutes' => $this->show_minutes,
            'showSeconds' => $this->show_seconds,
            'style' => $this->timer_style,
            'color' => $this->timer_color,
            'autoRefresh' => $this->auto_refresh,
            'refreshInterval' => $this->refresh_interval,
            'expiredMessage' => $this->expired_message,
            'showWarning' => $this->show_warning,
            'warningThreshold' => $this->warning_threshold,
        ];
    }
}
