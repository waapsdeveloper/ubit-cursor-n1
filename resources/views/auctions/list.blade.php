<x-app-layout>
    <div class="py-8 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">All Properties</h1>
                <p class="text-gray-600">Discover amazing properties available for auction</p>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white rounded-xl shadow-lg mb-8" x-data="{ expanded: false }">
                <form method="GET" action="{{ route('auctions.list') }}">
                    <!-- Compact Search Bar -->
                    <div class="p-4 border-b border-gray-100">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- Search Input -->
                            <div class="flex-1">
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        value="{{ request('search') }}"
                                        placeholder="Search properties by title or location..."
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ubit-purple-500 focus:border-ubit-purple-500"
                                    >                                    
                                </div>
                            </div>

                            <!-- Sort Dropdown -->
                            <div class="sm:w-48">
                                <select 
                                    name="sort" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ubit-purple-500 focus:border-ubit-purple-500 bg-white"
                                >
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="ending_soon" {{ request('sort') == 'ending_soon' ? 'selected' : '' }}>Ending Soon</option>
                                </select>
                            </div>

                            <!-- Toggle Filters Button -->
                            <button 
                                type="button" 
                                @click="expanded = !expanded"
                                class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                                </svg>
                                <span class="hidden sm:inline">Filters</span>
                                <svg class="w-4 h-4 ml-1 transition-transform" :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Search Button -->
                            <button 
                                type="submit" 
                                class="bg-ubit-purple-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-ubit-purple-600 transition-colors"
                            >
                                Search
                            </button>
                        </div>
                    </div>

                    <!-- Expandable Filters -->
                    <div 
                        x-show="expanded" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-2"
                        class="p-4 bg-gray-50 border-t border-gray-100"
                    >
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Min Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Price</label>
                                <input 
                                    type="number" 
                                    name="min_price" 
                                    value="{{ request('min_price') }}"
                                    placeholder="Enter min price"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ubit-purple-500"
                                >
                            </div>

                            <!-- Max Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Maximum Price</label>
                                <input 
                                    type="number" 
                                    name="max_price" 
                                    value="{{ request('max_price') }}"
                                    placeholder="Enter max price"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ubit-purple-500"
                                >
                            </div>

                            <!-- Clear Filters -->
                            <div class="flex items-end">
                                @if(request('search') || request('min_price') || request('max_price') || request('sort') != 'newest')
                                    <a 
                                        href="{{ route('auctions.list') }}" 
                                        class="text-gray-500 hover:text-gray-700 text-sm underline"
                                    >
                                        Clear All Filters
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Count -->
            <div class="mb-6">
                <p class="text-gray-600">
                    Showing {{ $auctions->firstItem() ?? 0 }} - {{ $auctions->lastItem() ?? 0 }} of {{ $auctions->total() }} properties
                </p>
            </div>

            <!-- Properties Grid -->
            @if($auctions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($auctions as $auction)
                        <!-- Property Card -->
                        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-gray-100">
                            <!-- Property Image -->
                            <div class="relative h-48 overflow-hidden bg-gray-100">
                                <img 
                                    src="{{ asset($auction->image) }}" 
                                    alt="{{ $auction->title }}"
                                    class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                                    loading="lazy"
                                >
                                <!-- Status Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-ubit-orange-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        Active Auction
                                    </span>
                                </div>
                            </div>

                            <!-- Timer - Centered below image -->
                            <div class="flex justify-center py-2 bg-gray-50 border-b border-gray-100">
                                <x-timer :auction="$auction" />
                            </div>

                            <!-- Property Details -->
                            <div class="p-4">
                                <!-- Title and Location -->
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1">
                                    {{ $auction->title }}
                                </h3>
                                <p class="text-gray-600 mb-3 flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-2 text-ubit-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $auction->location }}
                                </p>

                                <!-- Price -->
                                <div class="mb-3">
                                    <div class="text-sm text-gray-500">Starting Bid:</div>
                                    <div class="text-lg font-bold text-ubit-purple-500">
                                        PKR {{ number_format($auction->starting_bid, 0) }}
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex space-x-2">
                                    <a 
                                        href="{{ route('auction.detail', $auction->id) }}" 
                                        class="flex-1 bg-ubit-purple-500 text-white px-3 py-2 rounded-lg font-semibold text-center hover:bg-ubit-purple-600 transition-colors text-sm"
                                    >
                                        View Details
                                    </a>
                                    <a 
                                        href="{{ route('auction.bid', $auction->id) }}" 
                                        class="flex-1 border border-ubit-orange-500 text-ubit-orange-500 px-3 py-2 rounded-lg font-semibold text-center hover:bg-ubit-orange-500 hover:text-white transition-colors text-sm"
                                    >
                                        Place Bid
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $auctions->appends(request()->query())->links() }}
                </div>
            @else
                <!-- No Results -->
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No Properties Found</h3>
                    <p class="text-gray-500 mb-4">Try adjusting your search criteria or filters.</p>
                    <a 
                        href="{{ route('auctions.list') }}" 
                        class="inline-flex items-center bg-ubit-purple-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-ubit-purple-600 transition-colors"
                    >
                        View All Properties
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 