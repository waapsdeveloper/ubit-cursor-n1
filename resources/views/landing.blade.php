<x-landing-layout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-100 to-blue-300 dark:from-blue-900 dark:to-blue-700 py-20">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-8 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-blue-900 dark:text-blue-100">Exclusive Real Estate Auctions</h1>
                <p class="text-lg mb-6 text-blue-800 dark:text-blue-200">Bid on premium properties at Sahil e Firdaus. Invitation-only. Transparent. Secure. Fast.</p>
                <a href="#auctions" class="inline-block bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-blue-800 transition">View Auctions</a>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80" alt="Auction Hero" class="rounded-xl shadow-lg w-full max-w-md">
            </div>
        </div>
    </section>

    <!-- Slider Section -->
    <section id="auctions" class="py-16 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center text-blue-800 dark:text-blue-200">Featured Properties in Auction</h2>
            <div class="relative">
                <!-- Dynamic slider using Alpine.js and Blade -->
                <div x-data='{
                    active: 0,
                    items: [
                        @foreach($auctions as $auction)
                            {
                                title: @json($auction->title),
                                img: @json($auction->image ?? "https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80"),
                                location: @json($auction->location),
                                price: "PKR {{ number_format($auction->starting_bid, 0) }}"
                            }@if(!$loop->last),@endif
                        @endforeach
                        @if($auctions->isEmpty())
                            { title: 'Luxury Villa', img: 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80', location: 'Sahil e Firdaus', price: 'PKR 50,000,000' },
                            { title: 'Modern Apartment', img: 'https://images.unsplash.com/photo-1507089947368-19c1da9775ae?auto=format&fit=crop&w=600&q=80', location: 'Sahil e Firdaus', price: 'PKR 18,000,000' },
                            { title: 'Beachfront Plot', img: 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?auto=format&fit=crop&w=600&q=80', location: 'Sahil e Firdaus', price: 'PKR 30,000,000' }
                        @endif
                    ]
                }' class="max-w-3xl mx-auto">
                    <div class="overflow-hidden rounded-xl shadow-lg">
                        <template x-for="(item, idx) in items" :key="idx">
                            <div x-show="active === idx" class="transition-all duration-500">
                                <img :src="item.img" :alt="item.title" class="w-full h-64 object-cover">
                                <div class="p-6 bg-white dark:bg-gray-700">
                                    <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100" x-text="item.title"></h3>
                                    <p class="text-gray-700 dark:text-gray-300" x-text="item.location"></p>
                                    <p class="text-blue-700 dark:text-blue-400 font-semibold mt-2" x-text="item.price"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="flex justify-center mt-4 space-x-2">
                        <template x-for="(item, idx) in items" :key="idx">
                            <button @click="active = idx" :class="{'bg-blue-700': active === idx, 'bg-blue-200 dark:bg-blue-600': active !== idx}" class="w-3 h-3 rounded-full transition"></button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how" class="py-16 bg-blue-50 dark:bg-blue-900">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-3xl font-bold mb-8 text-center text-blue-800 dark:text-blue-200">How to Participate</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                    <div class="text-4xl mb-4">1️⃣</div>
                    <h3 class="font-bold text-lg mb-2 dark:text-gray-200">Get Invited</h3>
                    <p class="text-gray-600 dark:text-gray-400">Receive an exclusive invitation from the admin to register as a bidder.</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                    <div class="text-4xl mb-4">2️⃣</div>
                    <h3 class="font-bold text-lg mb-2 dark:text-gray-200">Pay Deposit</h3>
                    <p class="text-gray-600 dark:text-gray-400">Deposit the required amount into your wallet to unlock bidding on properties.</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                    <div class="text-4xl mb-4">3️⃣</div>
                    <h3 class="font-bold text-lg mb-2 dark:text-gray-200">Start Bidding</h3>
                    <p class="text-gray-600 dark:text-gray-400">Place your bids in real-time and compete for your dream property.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration/Invite Section -->
    <section id="register" class="py-16 bg-white dark:bg-gray-800 border-t dark:border-gray-700">
        <div class="container mx-auto px-4 max-w-xl text-center">
            <h2 class="text-2xl font-bold mb-4 text-blue-800 dark:text-blue-200">Have an Invitation?</h2>
            <p class="mb-6 text-gray-700 dark:text-gray-300">Enter your invite code or email to start the registration process and join the exclusive auctions.</p>
            <form method="GET" action="{{ route('register') }}" class="flex flex-col md:flex-row gap-4 justify-center">
                <input type="text" name="invite" placeholder="Enter invite code or email" class="flex-1 px-4 py-3 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-600" required>
                <button type="submit" class="bg-blue-700 text-white px-6 py-3 rounded font-semibold hover:bg-blue-800 transition">Register</button>
            </form>
            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">Registration is by invitation only.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t dark:border-gray-700 mt-12">
        <div class="container mx-auto px-4 py-8 flex flex-col md:flex-row justify-between items-center">
            <div class="text-gray-600 dark:text-gray-400">&copy; {{ date('Y') }} UBit for Sahil e Firdaus. All rights reserved.</div>
            <div class="space-x-4 mt-4 md:mt-0">
                <a href="#" class="text-gray-700 hover:text-blue-700 dark:text-gray-300 dark:hover:text-blue-400">Privacy Policy</a>
                <a href="#" class="text-gray-700 hover:text-blue-700 dark:text-gray-300 dark:hover:text-blue-400">Contact</a>
            </div>
        </div>
    </footer>
</x-landing-layout> 