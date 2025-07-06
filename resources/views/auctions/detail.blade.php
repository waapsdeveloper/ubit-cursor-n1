<x-app-layout>
    <div class="py-8 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('landing') }}" class="hover:text-ubit-purple-500">Home</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="#" class="hover:text-ubit-purple-500">Auctions</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-900">{{ $auction->title }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Images and Details -->
                <div class="lg:col-span-2">
                    <!-- Image Gallery -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                        <div class="relative">
                            <!-- Main Image -->
                            <div class="relative h-96 bg-gray-100">
                                <img 
                                    src="{{ asset($auction->image) }}" 
                                    alt="{{ $auction->title }}"
                                    class="w-full h-full object-cover"
                                    id="mainImage"
                                >
                                <!-- Image Navigation -->
                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                    <button class="w-3 h-3 bg-white rounded-full opacity-75 hover:opacity-100 transition-opacity" onclick="changeImage('{{ asset($auction->image) }}')"></button>
                                    <button class="w-3 h-3 bg-white rounded-full opacity-75 hover:opacity-100 transition-opacity" onclick="changeImage('{{ asset('images/demo/properties/pr-2.png') }}')"></button>
                                    <button class="w-3 h-3 bg-white rounded-full opacity-75 hover:opacity-100 transition-opacity" onclick="changeImage('{{ asset('images/demo/properties/pr-3.png') }}')"></button>
                                    <button class="w-3 h-3 bg-white rounded-full opacity-75 hover:opacity-100 transition-opacity" onclick="changeImage('{{ asset('images/demo/properties/pr-4.png') }}')"></button>
                                    <button class="w-3 h-3 bg-white rounded-full opacity-75 hover:opacity-100 transition-opacity" onclick="changeImage('{{ asset('images/demo/properties/pr-5.png') }}')"></button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Thumbnail Images -->
                        <div class="p-4 border-t border-gray-100">
                            <div class="flex space-x-2 overflow-x-auto">
                                <img src="{{ asset($auction->image) }}" alt="Image 1" class="w-16 h-16 object-cover rounded cursor-pointer border-2 border-ubit-purple-500" onclick="changeImage('{{ asset($auction->image) }}')">
                                <img src="{{ asset('images/demo/properties/pr-2.png') }}" alt="Image 2" class="w-16 h-16 object-cover rounded cursor-pointer border-2 border-transparent hover:border-gray-300" onclick="changeImage('{{ asset('images/demo/properties/pr-2.png') }}')">
                                <img src="{{ asset('images/demo/properties/pr-3.png') }}" alt="Image 3" class="w-16 h-16 object-cover rounded cursor-pointer border-2 border-transparent hover:border-gray-300" onclick="changeImage('{{ asset('images/demo/properties/pr-3.png') }}')">
                                <img src="{{ asset('images/demo/properties/pr-4.png') }}" alt="Image 4" class="w-16 h-16 object-cover rounded cursor-pointer border-2 border-transparent hover:border-gray-300" onclick="changeImage('{{ asset('images/demo/properties/pr-4.png') }}')">
                                <img src="{{ asset('images/demo/properties/pr-5.png') }}" alt="Image 5" class="w-16 h-16 object-cover rounded cursor-pointer border-2 border-transparent hover:border-gray-300" onclick="changeImage('{{ asset('images/demo/properties/pr-5.png') }}')">
                            </div>
                        </div>
                    </div>

                    <!-- Tabs Section -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <!-- Tab Navigation -->
                        <div class="border-b border-gray-200">
                            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                                <button class="tab-button active py-4 px-1 border-b-2 border-ubit-purple-500 text-ubit-purple-600 font-medium text-sm" onclick="showTab('description')">
                                    Description
                                </button>
                                <button class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm" onclick="showTab('history')">
                                    Auction History
                                </button>
                                <button class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm" onclick="showTab('maps')">
                                    Maps
                                </button>
                                <button class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm" onclick="showTab('offers')">
                                    More Offers
                                </button>
                                <button class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm" onclick="showTab('policies')">
                                    Store Policies
                                </button>
                                <button class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm" onclick="showTab('inquiries')">
                                    Inquiries
                                </button>
                            </nav>
                        </div>

                        <!-- Tab Content -->
                        <div class="p-6">
                            <!-- Description Tab -->
                            <div id="description" class="tab-content">
                                <h3 class="text-lg font-semibold mb-4">Description</h3>
                                <p class="text-gray-700 mb-4">
                                    Product galati a reality sandwich before you walk back in that boardroom fire up your browser, so come up with something buzzworthy, for it's about managing expectations yet baseline into the weeds.
                                </p>
                                <p class="text-gray-700 mb-4">
                                    Going forward knowledge is power or we need to button up our approach old boys club. Please use "solutionise" instead of solution ideas! 🙂 draw a line in the sand, for take five, punch the tree, and come back in here with a clear head. Out of scope data-point work flows , nor critical mass, and time to open the kimono yet move the needle.
                                </p>
                                <p class="text-gray-700">
                                    You better eat a reality sandwich before you walk back in that boardroom fire up your browser, so come up with something buzzworthy, for it's about managing expectations yet baseline into the weeds. Gain traction product management breakout fastworks we just need to put these last issues to bed, or table the discussion .
                                </p>
                            </div>

                            <!-- Auction History Tab -->
                            <div id="history" class="tab-content hidden">
                                <h3 class="text-lg font-semibold mb-4">Auction History</h3>
                                <div class="space-y-3">
                                    @forelse($bidHistory as $bid)
                                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                            <div>
                                                <span class="font-medium text-gray-900">{{ $bid->user->name }}</span>
                                                <span class="text-sm text-gray-500 ml-2">{{ $bid->created_at->format('M d, Y g:i A') }}</span>
                                            </div>
                                            <span class="font-bold text-ubit-purple-500">PKR {{ number_format($bid->amount, 0) }}</span>
                                        </div>
                                    @empty
                                        <p class="text-gray-500">No bids yet. Be the first to bid!</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Maps Tab -->
                            <div id="maps" class="tab-content hidden">
                                <h3 class="text-lg font-semibold mb-4">Location</h3>
                                <div class="bg-gray-100 h-64 rounded-lg flex items-center justify-center">
                                    <p class="text-gray-500">Map will be displayed here</p>
                                </div>
                                <p class="text-gray-700 mt-4">{{ $auction->location }}</p>
                            </div>

                            <!-- More Offers Tab -->
                            <div id="offers" class="tab-content hidden">
                                <h3 class="text-lg font-semibold mb-4">More Offers</h3>
                                <p class="text-gray-500">No additional offers available at this time.</p>
                            </div>

                            <!-- Store Policies Tab -->
                            <div id="policies" class="tab-content hidden">
                                <h3 class="text-lg font-semibold mb-4">Store Policies</h3>
                                <div class="space-y-4">
                                    <div>
                                        <h4 class="font-medium text-gray-900">Payment Terms</h4>
                                        <p class="text-gray-700">Payment must be completed within 7 days of auction end.</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Shipping</h4>
                                        <p class="text-gray-700">Property transfer will be handled by our legal team.</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Returns</h4>
                                        <p class="text-gray-700">No returns on auction purchases.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Inquiries Tab -->
                            <div id="inquiries" class="tab-content hidden">
                                <h3 class="text-lg font-semibold mb-4">Ask a Question</h3>
                                <form class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Your Question</label>
                                        <textarea rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ubit-purple-500"></textarea>
                                    </div>
                                    <button type="submit" class="bg-ubit-purple-500 text-white px-6 py-2 rounded-md hover:bg-ubit-purple-600 transition-colors">
                                        Submit Question
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Auction Info and Bidding -->
                <div class="lg:col-span-1">
                    <!-- Auction Info Card -->
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <div class="mb-4">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $auction->title }}</h1>
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <span>{{ $viewCount }} views</span>
                                <span class="mx-2">•</span>
                                <span class="text-green-600">🔍No reserve</span>
                            </div>
                        </div>

                        <!-- Current Bid -->
                        <div class="mb-6">
                            <div class="text-sm text-gray-500 mb-1">Current bid:</div>
                            <div class="text-2xl font-bold text-ubit-purple-500">
                                PKR {{ number_format($currentBid ? $currentBid->amount : $auction->starting_bid, 0) }}
                            </div>
                        </div>

                        <!-- Timer -->
                        <div class="mb-6">
                            <div class="text-sm text-gray-500 mb-2">Time left:</div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <x-timer :auction="$auction" />
                            </div>
                        </div>

                        <!-- Auction Details -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Auction ends:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($auction->end_time)->format('F j, Y g:i A') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Timezone:</span>
                                <span class="font-medium">UTC +3</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Item condition:</span>
                                <span class="font-medium">New</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">SKU:</span>
                                <span class="font-medium">BF{{ $auction->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Categories:</span>
                                <span class="font-medium">Terrains, Villa</span>
                            </div>
                        </div>

                        <!-- Bidding Section -->
                        <div class="space-y-4">
                            <div class="flex space-x-2">
                                <input type="number" placeholder="Enter bid amount" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ubit-purple-500">
                                <button class="bg-ubit-orange-500 text-white px-6 py-2 rounded-md hover:bg-ubit-orange-600 transition-colors">
                                    Bid
                                </button>
                            </div>
                            <button class="w-full bg-green-600 text-white py-3 rounded-md hover:bg-green-700 transition-colors font-semibold">
                                Buy now for PKR {{ number_format($auction->starting_bid * 1.5, 0) }}
                            </button>
                        </div>
                    </div>

                    <!-- Related Products -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Related products</h3>
                        <div class="space-y-4">
                            @foreach($relatedAuctions as $related)
                                <div class="flex space-x-3">
                                    <img src="{{ asset($related->image) }}" alt="{{ $related->title }}" class="w-16 h-16 object-cover rounded">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-sm text-gray-900">{{ $related->title }}</h4>
                                        <p class="text-sm text-ubit-purple-500 font-semibold">PKR {{ number_format($related->starting_bid, 0) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
            
            // Update active thumbnail
            const thumbnails = document.querySelectorAll('.thumbnail');
            thumbnails.forEach(thumb => {
                thumb.classList.remove('border-ubit-purple-500');
                thumb.classList.add('border-transparent');
            });
        }

        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('active', 'border-ubit-purple-500', 'text-ubit-purple-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected tab content
            document.getElementById(tabName).classList.remove('hidden');

            // Add active class to clicked button
            event.target.classList.add('active', 'border-ubit-purple-500', 'text-ubit-purple-600');
            event.target.classList.remove('border-transparent', 'text-gray-500');
        }
    </script>
</x-app-layout> 