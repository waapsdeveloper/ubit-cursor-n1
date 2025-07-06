@php
    $config = $timerSettings ? $timerSettings->getTimerConfig() : [
        'showTimer' => true,
        'showDays' => true,
        'showHours' => true,
        'showMinutes' => true,
        'showSeconds' => true,
        'style' => 'compact',
        'color' => 'orange',
        'autoRefresh' => true,
        'refreshInterval' => 1000,
        'expiredMessage' => 'Auction Ended',
        'showWarning' => true,
        'warningThreshold' => 3600,
    ];
@endphp

<div 
    id="{{ $timerId }}"
    x-data="auctionTimer({
        endTime: '{{ $auction->end_time }}',
        config: @js($config),
        initialTime: @js($timeRemaining)
    })"
    x-init="init()"
    class="auction-timer"
>
    <!-- Timer Display -->
    <div x-show="!isExpired" class="timer-display">
        <!-- Compact Style -->
        <div x-show="config.style === 'compact'" class="timer-compact" :class="'timer-compact-' + config.color">
            <div class="flex items-center justify-center space-x-1">
                <template x-if="config.showDays && timeRemaining.days > 0">
                    <div class="flex items-center">
                        <span class="text-sm font-bold" x-text="timeRemaining.days"></span>
                        <span class="text-xs ml-1">d</span>
                    </div>
                </template>
                <template x-if="config.showHours">
                    <div class="flex items-center">
                        <span class="text-sm font-bold" x-text="String(timeRemaining.hours).padStart(2, '0')"></span>
                        <span class="text-xs ml-1">h</span>
                    </div>
                </template>
                <template x-if="config.showMinutes">
                    <div class="flex items-center">
                        <span class="text-sm font-bold" x-text="String(timeRemaining.minutes).padStart(2, '0')"></span>
                        <span class="text-xs ml-1">m</span>
                    </div>
                </template>
                <template x-if="config.showSeconds">
                    <div class="flex items-center">
                        <span class="text-sm font-bold" x-text="String(timeRemaining.seconds).padStart(2, '0')"></span>
                        <span class="text-xs ml-1">s</span>
                    </div>
                </template>
            </div>
        </div>

        <!-- Detailed Style -->
        <div x-show="config.style === 'detailed'" class="timer-detailed">
            <div class="grid grid-cols-4 gap-2">
                <template x-if="config.showDays">
                    <div class="text-center">
                        <div class="text-lg font-bold" x-text="timeRemaining.days"></div>
                        <div class="text-xs text-gray-500">Days</div>
                    </div>
                </template>
                <template x-if="config.showHours">
                    <div class="text-center">
                        <div class="text-lg font-bold" x-text="String(timeRemaining.hours).padStart(2, '0')"></div>
                        <div class="text-xs text-gray-500">Hours</div>
                    </div>
                </template>
                <template x-if="config.showMinutes">
                    <div class="text-center">
                        <div class="text-lg font-bold" x-text="String(timeRemaining.minutes).padStart(2, '0')"></div>
                        <div class="text-xs text-gray-500">Minutes</div>
                    </div>
                </template>
                <template x-if="config.showSeconds">
                    <div class="text-center">
                        <div class="text-lg font-bold" x-text="String(timeRemaining.seconds).padStart(2, '0')"></div>
                        <div class="text-xs text-gray-500">Seconds</div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Minimal Style -->
        <div x-show="config.style === 'minimal'" class="timer-minimal">
            <span class="text-sm font-medium" x-text="formatMinimalTime()"></span>
        </div>
    </div>

    <!-- Expired Message -->
    <div x-show="isExpired" class="timer-expired">
        <span class="text-sm font-medium text-red-600" x-text="config.expiredMessage"></span>
    </div>

    <!-- Warning Indicator -->
    <div 
        x-show="config.showWarning && showWarning && !isExpired" 
        class="timer-warning mt-1"
    >
        <span class="text-xs text-red-500 font-medium">⚠️ Ending Soon!</span>
    </div>
</div>

<style>
.auction-timer {
    font-family: 'Inter', sans-serif;
}

.timer-compact {
    @apply bg-gray-100 px-3 py-1 rounded-lg;
}

.timer-detailed {
    @apply bg-white border border-gray-200 px-4 py-2 rounded-lg;
}

.timer-minimal {
    @apply text-gray-700;
}

.timer-expired {
    @apply text-center;
}

/* Color variants */
.timer-compact-orange {
    @apply bg-orange-100 text-orange-800;
}

.timer-compact-red {
    @apply bg-red-100 text-red-800;
}

.timer-compact-green {
    @apply bg-green-100 text-green-800;
}

.timer-compact-purple {
    @apply bg-purple-100 text-purple-800;
}
</style>