<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4 text-ubit-purple-500">{{ $title }}</h2>
            @if($subtitle)
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">{{ $subtitle }}</p>
            @endif
        </div>

        <!-- Properties Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($properties as $property)
                <!-- Property Card -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-gray-100">
                    <!-- Property Image -->
                    <div class="relative h-48 overflow-hidden bg-gray-100">
                        <img 
                            src="{{ asset($property->image) }}" 
                            alt="{{ $property->title }}"
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
                        <x-timer :auction="$property" />
                    </div>

                    <!-- Property Details -->
                    <div class="p-6">
                        <!-- Title and Location -->
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-1">
                            {{ $property->title }}
                        </h3>
                        <p class="text-gray-600 mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-ubit-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $property->location }}
                        </p>

                        <!-- Price and Deposit -->
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Starting Bid:</span>
                                <span class="text-lg font-bold text-ubit-purple-500">
                                    PKR {{ number_format($property->starting_bid, 0) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Deposit Required:</span>
                                <span class="text-sm font-semibold text-gray-700">
                                    PKR {{ number_format($property->deposit, 0) }}
                                </span>
                            </div>
                        </div>

                        <!-- Auction Details -->
                        <div class="border-t border-gray-100 pt-4 mb-4">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Bid Increment:</span>
                                    <p class="font-semibold text-gray-900">PKR {{ number_format($property->bid_increment, 0) }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Ends:</span>
                                    <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($property->end_time)->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-3">
                            <a 
                                href="#" 
                                class="flex-1 bg-ubit-orange-500 text-white px-4 py-2 rounded-lg font-semibold text-center hover:bg-ubit-orange-600 transition-colors"
                            >
                                Place Bid
                            </a>
                            <a 
                                href="{{ route('auction.detail', $property->id) }}" 
                                class="flex-1 border border-ubit-purple-500 text-ubit-purple-500 px-4 py-2 rounded-lg font-semibold text-center hover:bg-ubit-purple-500 hover:text-white transition-colors"
                            >
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- No Properties Message -->
                <div class="col-span-full text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No Properties Available</h3>
                    <p class="text-gray-500">Check back later for new auction properties.</p>
                </div>
            @endforelse
        </div>

        <!-- View All Button -->
        @if($showViewAll && $properties->count() > 0)
            <div class="text-center mt-12">
                <a 
                    href="#" 
                    class="inline-flex items-center bg-ubit-purple-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-ubit-purple-600 transition-colors"
                >
                    View All Properties
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</section> 