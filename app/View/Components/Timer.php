<?php

namespace App\View\Components;

use App\Models\Auction;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Timer extends Component
{
    public $auction;
    public $timerSettings;
    public $timeRemaining;
    public $timerId;

    /**
     * Create a new component instance.
     */
    public function __construct(Auction $auction, $timerSettings = null)
    {
        $this->auction = $auction;
        $this->timerSettings = $timerSettings ?? $auction->timerSettings;
        $this->timeRemaining = $auction->getTimeRemaining();
        $this->timerId = 'timer-' . $auction->id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.timer');
    }
}
