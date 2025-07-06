<x-landing-layout>
    <!-- Hero Section Component -->
    <x-hero-section 
        title="Exclusive Real Estate <span class='text-ubit-purple-500'>Auctions</span>"
        subtitle="Bid on premium properties at Sahil e Firdaus. <span class='font-semibold text-white'>Invitation-only. Transparent. Secure. Fast.</span>"
        background-image="{{ asset('images/demo/housebg1.jpg') }}"
        cta-text="View Auctions"
        cta-link="#auctions"
        secondary-cta-text="Get Invitation"
        secondary-cta-link="#register"
        :features="['Secure Bidding Platform', 'Real-time Updates']"
        badge-text="🏆 Premium Real Estate"
    />

    <!-- Slider Section -->
    <section id="auctions" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center text-ubit-purple-500">Featured Properties in Auction</h2>
            <div class="relative">
                <!-- Dynamic slider using Alpine.js and Blade -->
                <div x-data='{
                    active: 0,
                    items: [
                        @foreach($auctions as $auction)
                            {
                                title: @json($auction->title),
                                img: @json($auction->image ?? asset('images/demo/properties/pr-1.png')),
                                location: @json($auction->location),
                                price: "PKR {{ number_format($auction->starting_bid, 0) }}"
                            }@if(!$loop->last),@endif
                        @endforeach
                        @if($auctions->isEmpty())
                            { title: 'Luxury Villa with Ocean View', img: '{{ asset("images/demo/properties/pr-1.png") }}', location: 'Sahil e Firdaus - Beachfront', price: 'PKR 25,000,000' },
                            { title: 'Modern Downtown Apartment', img: '{{ asset("images/demo/properties/pr-2.png") }}', location: 'Sahil e Firdaus - Downtown', price: 'PKR 18,000,000' },
                            { title: 'Beachfront Penthouse Suite', img: '{{ asset("images/demo/properties/pr-3.png") }}', location: 'Sahil e Firdaus - Ocean Drive', price: 'PKR 35,000,000' },
                            { title: 'Garden Villa with Pool', img: '{{ asset("images/demo/properties/pr-4.png") }}', location: 'Sahil e Firdaus - Garden District', price: 'PKR 22,000,000' },
                            { title: 'Executive Townhouse', img: '{{ asset("images/demo/properties/pr-5.png") }}', location: 'Sahil e Firdaus - Executive Heights', price: 'PKR 28,000,000' },
                            { title: 'Waterfront Luxury Home', img: '{{ asset("images/demo/properties/pr-6.png") }}', location: 'Sahil e Firdaus - Waterfront', price: 'PKR 42,000,000' },
                            { title: 'Mountain View Estate', img: '{{ asset("images/demo/properties/pr-7.png") }}', location: 'Sahil e Firdaus - Mountain View', price: 'PKR 38,000,000' },
                            { title: 'Urban Loft Apartment', img: '{{ asset("images/demo/properties/pr-8.png") }}', location: 'Sahil e Firdaus - Urban Center', price: 'PKR 15,000,000' },
                            { title: 'Seaside Villa Complex', img: '{{ asset("images/demo/properties/pr-9.png") }}', location: 'Sahil e Firdaus - Coastal Resort', price: 'PKR 45,000,000' }
                        @endif
                    ]
                }' class="max-w-3xl mx-auto">
                    <div class="overflow-hidden rounded-xl shadow-lg">
                        <template x-for="(item, idx) in items" :key="idx">
                            <div x-show="active === idx" class="transition-all duration-500">
                                <img :src="item.img" :alt="item.title" class="w-full h-64 object-cover">
                                <div class="p-6 bg-white">
                                    <h3 class="text-xl font-bold text-gray-900" x-text="item.title"></h3>
                                    <p class="text-gray-700" x-text="item.location"></p>
                                    <p class="text-ubit-purple-500 font-semibold mt-2" x-text="item.price"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="flex justify-center mt-4 space-x-2">
                        <template x-for="(item, idx) in items" :key="idx">
                            <button @click="active = idx" :class="{'bg-ubit-purple-500': active === idx, 'bg-gray-300': active !== idx}" class="w-3 h-3 rounded-full transition"></button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how" class="py-16" style="background-color: #F8F7FF;">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-3xl font-bold mb-8 text-center text-ubit-purple-500">How to Participate</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-4xl mb-4">1️⃣</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-900">Get Invited</h3>
                    <p class="text-gray-600">Receive an exclusive invitation from the admin to register as a bidder.</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-4xl mb-4">2️⃣</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-900">Pay Deposit</h3>
                    <p class="text-gray-600">Deposit the required amount into your wallet to unlock bidding on properties.</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-4xl mb-4">3️⃣</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-900">Start Bidding</h3>
                    <p class="text-gray-600">Place your bids in real-time and compete for your dream property.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration/Invite Section -->
    <section id="register" class="py-16 bg-white border-t border-gray-200">
        <div class="container mx-auto px-4 max-w-xl text-center">
            <h2 class="text-2xl font-bold mb-4 text-ubit-purple-500">Have an Invitation?</h2>
            <p class="mb-6 text-gray-700">Enter your invite code or email to start the registration process and join the exclusive auctions.</p>
            <form method="GET" action="{{ route('register') }}" class="flex flex-col md:flex-row gap-4 justify-center">
                <input type="text" name="invite" placeholder="Enter invite code or email" class="flex-1 px-4 py-3 rounded border border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-ubit-purple-500 focus:border-ubit-purple-500" required>
                <button type="submit" class="bg-ubit-purple-500 text-white px-6 py-3 rounded font-semibold hover:bg-ubit-purple-600 transition">Register</button>
            </form>
            <p class="mt-4 text-sm text-gray-500">Registration is by invitation only.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="container mx-auto px-4 py-8 flex flex-col md:flex-row justify-between items-center">
            <div class="text-gray-600">&copy; {{ date('Y') }} UBit for Sahil e Firdaus. All rights reserved.</div>
            <div class="space-x-4 mt-4 md:mt-0">
                <a href="#" class="text-gray-700 hover:text-ubit-purple-500">Privacy Policy</a>
                <a href="#" class="text-gray-700 hover:text-ubit-purple-500">Contact</a>
            </div>
        </div>
    </footer>
</x-landing-layout>