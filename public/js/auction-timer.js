/**
 * Auction Timer Alpine.js Component
 * Handles countdown timers for auction properties
 */
function auctionTimer(config) {
    return {
        endTime: config.endTime,
        config: config.config,
        timeRemaining: config.initialTime || { days: 0, hours: 0, minutes: 0, seconds: 0 },
        isExpired: config.initialTime?.is_expired || false,
        showWarning: false,
        timerInterval: null,

        init() {
            this.updateTimer();
            
            if (this.config.autoRefresh && !this.isExpired) {
                this.startTimer();
            }
        },

        startTimer() {
            this.timerInterval = setInterval(() => {
                this.updateTimer();
            }, this.config.refreshInterval);
        },

        stopTimer() {
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
                this.timerInterval = null;
            }
        },

        updateTimer() {
            const now = new Date();
            const end = new Date(this.endTime);
            const diff = end - now;

            if (diff <= 0) {
                this.isExpired = true;
                this.timeRemaining = {
                    days: 0,
                    hours: 0,
                    minutes: 0,
                    seconds: 0,
                    total_seconds: 0
                };
                this.stopTimer();
                this.showExpiredNotification();
                return;
            }

            // Calculate time remaining
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            this.timeRemaining = {
                days: days,
                hours: hours,
                minutes: minutes,
                seconds: seconds,
                total_seconds: Math.floor(diff / 1000)
            };

            // Check for warning threshold
            if (this.config.showWarning && this.timeRemaining.total_seconds <= this.config.warningThreshold) {
                this.showWarning = true;
                this.showWarningNotification();
            }
        },

        formatMinimalTime() {
            if (this.timeRemaining.days > 0) {
                return `${this.timeRemaining.days}d ${this.timeRemaining.hours}h`;
            } else if (this.timeRemaining.hours > 0) {
                return `${this.timeRemaining.hours}h ${this.timeRemaining.minutes}m`;
            } else if (this.timeRemaining.minutes > 0) {
                return `${this.timeRemaining.minutes}m ${this.timeRemaining.seconds}s`;
            } else {
                return `${this.timeRemaining.seconds}s`;
            }
        },

        showExpiredNotification() {
            // You can customize this to show a notification
            console.log('Auction expired:', this.config.expiredMessage);
            
            // Optional: Dispatch custom event
            this.$el.dispatchEvent(new CustomEvent('auction-expired', {
                detail: { auctionId: this.$el.id.replace('timer-', '') }
            }));
        },

        showWarningNotification() {
            // You can customize this to show a warning notification
            console.log('Auction ending soon!');
            
            // Optional: Dispatch custom event
            this.$el.dispatchEvent(new CustomEvent('auction-warning', {
                detail: { 
                    auctionId: this.$el.id.replace('timer-', ''),
                    timeRemaining: this.timeRemaining
                }
            }));
        },

        // Cleanup when component is destroyed
        destroy() {
            this.stopTimer();
        }
    };
}

// Global timer management
window.AuctionTimerManager = {
    timers: new Map(),

    registerTimer(timerId, timerInstance) {
        this.timers.set(timerId, timerInstance);
    },

    unregisterTimer(timerId) {
        const timer = this.timers.get(timerId);
        if (timer) {
            timer.destroy();
            this.timers.delete(timerId);
        }
    },

    pauseAllTimers() {
        this.timers.forEach(timer => {
            timer.stopTimer();
        });
    },

    resumeAllTimers() {
        this.timers.forEach(timer => {
            if (!timer.isExpired) {
                timer.startTimer();
            }
        });
    },

    // Utility function to format time
    formatTime(seconds) {
        const days = Math.floor(seconds / (24 * 60 * 60));
        const hours = Math.floor((seconds % (24 * 60 * 60)) / (60 * 60));
        const minutes = Math.floor((seconds % (60 * 60)) / 60);
        const secs = seconds % 60;

        return {
            days,
            hours,
            minutes,
            seconds: secs
        };
    }
};

// Handle page visibility changes to pause/resume timers
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        window.AuctionTimerManager.pauseAllTimers();
    } else {
        window.AuctionTimerManager.resumeAllTimers();
    }
});

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    window.AuctionTimerManager.timers.forEach(timer => {
        timer.destroy();
    });
}); 