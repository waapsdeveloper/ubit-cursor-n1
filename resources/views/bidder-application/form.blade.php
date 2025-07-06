<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Become a Bidder</h1>
                <p class="text-lg text-gray-600">Complete the application process to gain bidding access</p>
            </div>

            <!-- 3-Step Process -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Application Process</h2>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-ubit-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-ubit-purple-600">1</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Make Deposit</h3>
                        <p class="text-gray-600 text-sm">
                            Send PKR {{ number_format(config('auction.deposit_amount', 50000), 0) }} to our designated account
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-ubit-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-ubit-orange-600">2</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Verification</h3>
                        <p class="text-gray-600 text-sm">
                            We'll verify your payment and send you an invitation link
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-green-600">3</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Activate</h3>
                        <p class="text-gray-600 text-sm">
                            Use the invitation link to activate your bidder account
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bank Details -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Bank Account Details</h2>
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Bank Name:</span>
                            <p class="font-semibold text-gray-900">HBL Bank</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Account Title:</span>
                            <p class="font-semibold text-gray-900">Sahil e Firdaus Auctions</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Account Number:</span>
                            <p class="font-semibold text-gray-900">1234-5678-9012-3456</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Deposit Amount:</span>
                            <p class="font-semibold text-ubit-purple-600">PKR {{ number_format(config('auction.deposit_amount', 50000), 0) }}</p>
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800">
                            <strong>Important:</strong> Please include your name in the transaction description for easy identification.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Application Form</h2>
                
                <form method="POST" action="{{ route('bidder.application.submit') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    value="{{ old('phone') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ubit-purple-500"
                                    placeholder="+92 300 1234567"
                                    required
                                >
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cnic" class="block text-sm font-medium text-gray-700 mb-1">CNIC Number</label>
                                <input 
                                    type="text" 
                                    id="cnic" 
                                    name="cnic" 
                                    value="{{ old('cnic') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ubit-purple-500"
                                    placeholder="12345-1234567-1"
                                    required
                                >
                                @error('cnic')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                            
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-1">Your Bank Name</label>
                                <input 
                                    type="text" 
                                    id="bank_name" 
                                    name="bank_name" 
                                    value="{{ old('bank_name') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ubit-purple-500"
                                    placeholder="e.g., HBL, UBL, MCB"
                                    required
                                >
                                @error('bank_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="account_number" class="block text-sm font-medium text-gray-700 mb-1">Your Account Number</label>
                                <input 
                                    type="text" 
                                    id="account_number" 
                                    name="account_number" 
                                    value="{{ old('account_number') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ubit-purple-500"
                                    placeholder="Account number used for payment"
                                    required
                                >
                                @error('account_number')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="transaction_id" class="block text-sm font-medium text-gray-700 mb-1">Transaction ID</label>
                                <input 
                                    type="text" 
                                    id="transaction_id" 
                                    name="transaction_id" 
                                    value="{{ old('transaction_id') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-ubit-purple-500"
                                    placeholder="Transaction ID from your bank"
                                    required
                                >
                                @error('transaction_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Payment Proof Upload -->
                    <div class="mt-6">
                        <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">Payment Proof</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                            <input 
                                type="file" 
                                id="payment_proof" 
                                name="payment_proof" 
                                class="hidden"
                                accept="image/*,.pdf"
                                required
                            >
                            <label for="payment_proof" class="cursor-pointer">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium text-ubit-purple-600">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, PDF up to 2MB</p>
                            </label>
                        </div>
                        @error('payment_proof')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mt-6">
                        <label class="flex items-start">
                            <input 
                                type="checkbox" 
                                name="agree_terms" 
                                required 
                                class="mt-1 h-4 w-4 text-ubit-purple-600 focus:ring-ubit-purple-500 border-gray-300 rounded"
                            >
                            <span class="ml-2 text-sm text-gray-700">
                                I agree to the <a href="#" class="text-ubit-purple-600 hover:text-ubit-purple-500">Terms and Conditions</a> and understand that the deposit is refundable if my application is not approved.
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button 
                            type="submit" 
                            class="w-full bg-ubit-purple-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-ubit-purple-600 transition-colors"
                        >
                            Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // File upload preview
        document.getElementById('payment_proof').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const label = e.target.nextElementSibling;
                label.innerHTML = `
                    <svg class="w-12 h-12 text-green-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-600">
                        <span class="font-medium text-green-600">File selected:</span> ${file.name}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Click to change file</p>
                `;
            }
        });
    </script>
</x-app-layout> 