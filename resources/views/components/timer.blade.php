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

    data-end-time="{{ $auction->end_time }}"
>
    <!-- Digital Timer Display -->
    <div class="timer-digital">
        <div class="flex items-center justify-center">
            <span id="timer-{{ $auction->id }}" class="bg-white px-3 py-1 rounded-md shadow-sm border border-gray-200 text-base font-mono font-bold text-gray-800">
                {{ $timeRemaining['days'] }} : {{ $timeRemaining['hours'] }} : {{ $timeRemaining['minutes'] }} : {{ $timeRemaining['seconds'] }}
            </span>
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
        if (days > 0) {
            timeString += String(days).padStart(2, '0') + ' : ';
        }
        timeString += String(hours).padStart(2, '0') + ' : ';
        timeString += String(minutes).padStart(2, '0') + ' : ';
        timeString += String(seconds).padStart(2, '0');
        
        timerElement.textContent = timeString;
    }
    
    // Update immediately
    updateTimer();
    
    // Update every second
    setInterval(updateTimer, 1000);
});
</script>

<style>
.auction-timer {
    font-family: 'Inter', sans-serif;
    display: inline-block;
}

.timer-digital {
    @apply w-full;
}

.timer-digital span {
    @apply font-mono;
    font-variant-numeric: tabular-nums;
}
</style>