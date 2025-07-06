<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('landing') }}" class="hover:text-ubit-purple-500">Home</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('auctions.list') }}" class="hover:text-ubit-purple-500">Auctions</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('auction.detail', $auction->id) }}" class="hover:text-ubit-purple-500">{{ $auction->title }}</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-900">Place Bid</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Auction Details -->
                <div class="lg:col-span-2">
                    <!-- Auction Info Card -->
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $auction->title }}</h1>
                                <p class="text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-ubit-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $auction->location }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="bg-ubit-orange-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    Active Auction
                                </span>
                            </div>
                        </div>

                        <!-- Property Image -->
                        <div class="mb-6">
                            <img 
                                src="{{ asset($auction->image) }}" 
                                alt="{{ $auction->title }}"
                                class="w-full h-64 object-cover rounded-lg"
                            >
                        </div>

                        <!-- Current Bid Info -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm text-gray-500 mb-1">Current Highest Bid:</div>
                                    <div class="text-2xl font-bold text-ubit-purple-500">
                                        PKR {{ number_format($currentAmount, 0) }}
                                    </div>
                                    @if($currentBid)
                                        <div class="text-sm text-gray-600 mt-1">
                                            by {{ $currentBid->user->name }} • {{ $currentBid->created_at->diffForHumans() }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 mb-1">Minimum Next Bid:</div>
                                    <div class="text-xl font-bold text-ubit-orange-500">
                                        PKR {{ number_format($minNextBid, 0) }}
                                    </div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        Bid increment: PKR {{ number_format($auction->bid_increment, 0) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timer -->
                        <div class="mb-6">
                            <div class="text-sm text-gray-500 mb-2">Time remaining:</div>
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <x-timer :auction="$auction" />
                            </div>
                        </div>

                        <!-- Auction Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-3">Auction Details</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Starting Bid:</span>
                                        <span class="font-medium">PKR {{ number_format($auction->starting_bid, 0) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Deposit Required:</span>
                                        <span class="font-medium">PKR {{ number_format($auction->deposit, 0) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Bid Increment:</span>
                                        <span class="font-medium">PKR {{ number_format($auction->bid_increment, 0) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Auction Ends:</span>
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($auction->end_time)->format('M j, Y g:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-3">Important Information</h3>
                                <div class="space-y-2 text-sm text-gray-600">
                                    <div class="flex items-start">
                                        <svg class="w-4 h-4 mr-2 mt-0.5 text-ubit-purple-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Bids are binding and cannot be retracted</span>
                                    </div>
                                    <div class="flex items-start">
                                        <svg class="w-4 h-4 mr-2 mt-0.5 text-ubit-purple-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Payment must be completed within 7 days</span>
                                    </div>
                                    <div class="flex items-start">
                                        <svg class="w-4 h-4 mr-2 mt-0.5 text-ubit-purple-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Deposit is refundable if you don't win</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bid History -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Bid History</h3>
                        @if($recentBids->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentBids as $bid)
                                    <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-ubit-purple-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-ubit-purple-600 font-semibold text-sm">
                                                    {{ strtoupper(substr($bid->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $bid->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $bid->created_at->format('M j, Y g:i A') }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold text-ubit-purple-500">PKR {{ number_format($bid->amount, 0) }}</div>
                                            @if($loop->first)
                                                <div class="text-xs text-green-600 font-medium">Current Highest</div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 mb-2">
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-500">No bids yet. Be the first to bid!</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Bidding Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Place Your Bid</h2>

                        @guest
                            <!-- Login Required -->
                            <div class="text-center py-8">
                                <div class="text-gray-400 mb-4">
                                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Login Required</h3>
                                <p class="text-gray-600 mb-6">You must be logged in to place a bid.</p>
                                <div class="space-y-3">
                                    <a href="{{ route('login') }}" class="w-full bg-ubit-purple-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-ubit-purple-600 transition-colors block text-center">
                                        Login to Bid
                                    </a>
                                    <a href="{{ route('register') }}" class="w-full border border-ubit-purple-500 text-ubit-purple-500 px-6 py-3 rounded-lg font-semibold hover:bg-ubit-purple-50 transition-colors block text-center">
                                        Create Account
                                    </a>
                                </div>
                            </div>
                        @else
                            @if(!$canBid)
                                <!-- Cannot Bid (Own Auction) -->
                                <div class="text-center py-8">
                                    <div class="text-gray-400 mb-4">
                                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Cannot Bid</h3>
                                    <p class="text-gray-600">You cannot bid on your own auction.</p>
                                </div>
                            @else
                                <!-- Bidding Form -->
                                <form method="POST" action="{{ route('auction.bid', $auction->id) }}" class="space-y-6">
                                    @csrf
                                    
                                    <!-- Current Bid Display -->
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="text-sm text-gray-500 mb-1">Current Highest Bid:</div>
                                        <div class="text-2xl font-bold text-ubit-purple-500">
                                            PKR {{ number_format($currentAmount, 0) }}
                                        </div>
                                    </div>

                                    <!-- Bid Amount Input -->
                                    <div>
                                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                            Your Bid Amount (PKR)
                                        </label>
                                        <div class="relative">                                            
                                            <input 
                                                type="number" 
                                                id="amount"
                                                name="amount" 
                                                min="{{ $minNextBid }}"
                                                step="{{ $auction->bid_increment }}"
                                                value="{{ $minNextBid }}"
                                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ubit-purple-500 focus:border-ubit-purple-500"
                                                required
                                            >
                                        </div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            Minimum bid: PKR {{ number_format($minNextBid, 0) }}
                                        </div>
                                    </div>

                                    <!-- Quick Bid Buttons -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Quick Bid Options</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <button 
                                                type="button" 
                                                onclick="setBidAmount({{ $minNextBid }})"
                                                class="px-3 py-2 border border-gray-300 rounded-md text-sm hover:bg-gray-50 transition-colors"
                                            >
                                                Min: {{ number_format($minNextBid, 0) }}
                                            </button>
                                            <button 
                                                type="button" 
                                                onclick="setBidAmount({{ $minNextBid + $auction->bid_increment }})"
                                                class="px-3 py-2 border border-gray-300 rounded-md text-sm hover:bg-gray-50 transition-colors"
                                            >
                                                +{{ number_format($auction->bid_increment, 0) }}
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Terms Agreement -->
                                    <div class="flex items-start">
                                        <input 
                                            type="checkbox" 
                                            id="agree_terms" 
                                            name="agree_terms" 
                                            class="mt-1 h-4 w-4 text-ubit-purple-600 focus:ring-ubit-purple-500 border-gray-300 rounded"
                                            required
                                        >
                                        <label for="agree_terms" class="ml-2 text-sm text-gray-700">
                                            I agree to the <a href="#" class="text-ubit-purple-500 hover:underline">auction terms and conditions</a> and understand that bids are binding.
                                        </label>
                                    </div>

                                    <!-- Submit Button -->
                                    <button 
                                        type="submit" 
                                        class="w-full bg-ubit-orange-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-ubit-orange-600 transition-colors"
                                    >
                                        Place Bid
                                    </button>
                                </form>

                                <!-- Additional Info -->
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <div class="text-sm text-gray-600 space-y-2">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>Secure bidding system</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>Real-time updates</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>Email notifications</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setBidAmount(amount) {
            document.getElementById('amount').value = amount;
        }
    </script>
</x-app-layout> 