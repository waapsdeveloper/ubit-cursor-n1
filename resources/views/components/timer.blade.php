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
    class="auction-timer"
    title="Timer for {{ $auction->title }}"
    style="border: 2px solid red; min-height: 30px;"
    data-end-time="{{ $auction->end_time }}"
>
    <!-- Static Timer Display -->
    <div class="timer-compact timer-compact-orange">
        <div class="flex items-center justify-center space-x-1 text-sm font-bold">
            <span id="timer-{{ $auction->id }}">{{ $timeRemaining['days'] }}d {{ $timeRemaining['hours'] }}h {{ $timeRemaining['minutes'] }}m {{ $timeRemaining['seconds'] }}s</span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const timerElement = document.getElementById('timer-{{ $auction->id }}');
    const endTime = new Date('{{ $auction->end_time }}');
    
    function updateTimer() {
        const now = new Date();
        const diff = endTime - now;
        
        if (diff <= 0) {
            timerElement.textContent = 'Auction Ended';
            return;
        }
        
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        let timeString = '';
        if (days > 0) timeString += days + 'd ';
        timeString += String(hours).padStart(2, '0') + 'h ';
        timeString += String(minutes).padStart(2, '0') + 'm ';
        timeString += String(seconds).padStart(2, '0') + 's';
        
        timerElement.textContent = timeString;
    }
    
    // Update immediately
    updateTimer();
    
    // Update every second
    setInterval(updateTimer, 1000);
});
</script>




</div>

<style>
.auction-timer {
    font-family: 'Inter', sans-serif;
    min-width: 80px;
    display: inline-block;
}

.timer-compact {
    @apply bg-white px-3 py-2 rounded-lg shadow-lg min-w-max border border-gray-200;
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