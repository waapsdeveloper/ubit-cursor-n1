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

    <!-- Featured Properties Section -->
    <x-featured-properties 
        title="Featured Properties in Auction"
        subtitle="Discover exclusive properties available for bidding at Sahil e Firdaus"
        :show-view-all="true"
        :limit="6"
    />

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