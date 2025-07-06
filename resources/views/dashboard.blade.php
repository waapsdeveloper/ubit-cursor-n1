<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4">
            <!-- Welcome Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ $user->name }}!</h1>
                <p class="text-gray-600">Here's your auction activity overview</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Bids Placed -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-ubit-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-ubit-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Bids</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalBidsPlaced }}</p>
                        </div>
                    </div>
                </div>

                <!-- Auctions Won -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Auctions Won</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalAuctionsWon }}</p>
                        </div>
                    </div>
                </div>

                <!-- Auctions Created -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-ubit-orange-100 rounded-lg">
                            <svg class="w-6 h-6 text-ubit-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Auctions Created</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalAuctionsCreated }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Bid Amount -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Bid Amount</p>
                            <p class="text-2xl font-bold text-gray-900">PKR {{ number_format($totalBidAmount, 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Active Bids & Current Highest Bids -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Active Bids -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Active Bids</h2>
                            <a href="{{ route('auctions.list') }}" class="text-ubit-purple-500 hover:text-ubit-purple-600 text-sm font-medium">
                                View All Auctions
                            </a>
                        </div>
                        
                        @if($activeBids->count() > 0)
                            <div class="space-y-4">
                                @foreach($activeBids as $bid)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center mb-2">
                                                    <img src="{{ asset($bid->auction->image) }}" alt="{{ $bid->auction->title }}" class="w-16 h-16 object-cover rounded-lg mr-4">
                                                    <div>
                                                        <h3 class="font-semibold text-gray-900">{{ $bid->auction->title }}</h3>
                                                        <p class="text-sm text-gray-600">{{ $bid->auction->location }}</p>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 text-sm">
                                                    <div>
                                                        <span class="text-gray-500">Your Bid:</span>
                                                        <span class="font-semibold text-ubit-purple-500">PKR {{ number_format($bid->amount, 0) }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-500">Current Highest:</span>
                                                        <span class="font-semibold">
                                                            PKR {{ number_format($bid->auction->bids()->max('amount'), 0) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right ml-4">
                                                <div class="mb-2">
                                                    @if($bid->amount === $bid->auction->bids()->max('amount'))
                                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                                            Highest Bid
                                                        </span>
                                                    @else
                                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">
                                                            Outbid
                                                        </span>
                                                    @endif
                                                </div>
                                                <a href="{{ route('auction.bid', $bid->auction->id) }}" class="text-ubit-purple-500 hover:text-ubit-purple-600 text-sm font-medium">
                                                    Place New Bid
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 mb-4">
                                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Active Bids</h3>
                                <p class="text-gray-500 mb-4">Start bidding on properties to see them here.</p>
                                <a href="{{ route('auctions.list') }}" class="inline-flex items-center bg-ubit-purple-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-ubit-purple-600 transition-colors">
                                    Browse Auctions
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Won Auctions -->
                    @if($wonAuctions->count() > 0)
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Won Auctions</h2>
                            <div class="space-y-4">
                                @foreach($wonAuctions as $auction)
                                    <div class="border border-green-200 bg-green-50 rounded-lg p-4">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center mb-2">
                                                    <img src="{{ asset($auction->image) }}" alt="{{ $auction->title }}" class="w-16 h-16 object-cover rounded-lg mr-4">
                                                    <div>
                                                        <h3 class="font-semibold text-gray-900">{{ $auction->title }}</h3>
                                                        <p class="text-sm text-gray-600">{{ $auction->location }}</p>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 text-sm">
                                                    <div>
                                                        <span class="text-gray-500">Winning Bid:</span>
                                                        <span class="font-semibold text-green-600">PKR {{ number_format($auction->bids->first()->amount, 0) }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-500">Ended:</span>
                                                        <span class="font-semibold">{{ $auction->end_time->format('M j, Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right ml-4">
                                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                                    Won
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Recent Activity & Created Auctions -->
                <div class="space-y-8">
                    <!-- Recent Bid History -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Recent Activity</h2>
                        @if($recentBids->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentBids as $bid)
                                    <div class="flex items-center py-2 border-b border-gray-100 last:border-b-0">
                                        <div class="w-8 h-8 bg-ubit-purple-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-ubit-purple-600 font-semibold text-xs">
                                                {{ strtoupper(substr($bid->auction->title, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900">{{ $bid->auction->title }}</div>
                                            <div class="text-xs text-gray-500">{{ $bid->created_at->diffForHumans() }}</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-semibold text-ubit-purple-500">PKR {{ number_format($bid->amount, 0) }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No recent activity</p>
                        @endif
                    </div>

                    <!-- Created Auctions -->
                    @if($createdAuctions->count() > 0)
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Your Auctions</h2>
                            <div class="space-y-3">
                                @foreach($createdAuctions->take(5) as $auction)
                                    <div class="border border-gray-200 rounded-lg p-3">
                                        <div class="flex items-center mb-2">
                                            <img src="{{ asset($auction->image) }}" alt="{{ $auction->title }}" class="w-12 h-12 object-cover rounded mr-3">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-sm text-gray-900">{{ $auction->title }}</h4>
                                                <p class="text-xs text-gray-500">{{ $auction->location }}</p>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-gray-500">{{ $auction->bids->count() }} bids</span>
                                            <span class="font-medium text-ubit-purple-500">
                                                @if($auction->status === 'active')
                                                    Active
                                                @elseif($auction->status === 'ended')
                                                    Ended
                                                @else
                                                    {{ ucfirst($auction->status) }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if($createdAuctions->count() > 5)
                                <div class="mt-4 text-center">
                                    <a href="#" class="text-ubit-purple-500 hover:text-ubit-purple-600 text-sm font-medium">
                                        View All ({{ $createdAuctions->count() }})
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                        <div class="space-y-3">
                            <a href="{{ route('auctions.list') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 text-ubit-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">Browse Auctions</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 text-ubit-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">Edit Profile</span>
                            </a>
                            <a href="#" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 text-ubit-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">Bid History</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
