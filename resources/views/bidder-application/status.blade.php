<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Application Status</h1>
                <p class="text-lg text-gray-600">Track your bidder application progress</p>
            </div>

            <!-- Status Timeline -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Application Progress</h2>
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-{{ $application->getStatusBadgeColor() }}-100 text-{{ $application->getStatusBadgeColor() }}-800">
                        {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                    </span>
                </div>

                <!-- Timeline -->
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                    <!-- Step 1: Application Submitted -->
                    <div class="relative flex items-start mb-8">
                        <div class="flex-shrink-0 w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-semibold text-gray-900">Application Submitted</h3>
                            <p class="text-gray-600 text-sm">{{ $application->created_at->format('M d, Y \a\t g:i A') }}</p>
                            <p class="text-gray-600 mt-1">Your application has been received and is under review.</p>
                        </div>
                    </div>

                    <!-- Step 2: Payment Verification -->
                    <div class="relative flex items-start mb-8">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full flex items-center justify-center 
                            {{ $application->isPaymentVerified() ? 'bg-green-100' : 'bg-gray-100' }}">
                            @if($application->isPaymentVerified())
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-semibold text-gray-900">Payment Verification</h3>
                            @if($application->isPaymentVerified())
                                <p class="text-gray-600 text-sm">{{ $application->payment_verified_at->format('M d, Y \a\t g:i A') }}</p>
                                <p class="text-green-600 mt-1">Payment has been verified successfully!</p>
                            @else
                                <p class="text-gray-600 mt-1">We're currently verifying your payment. This usually takes 24-48 hours.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Step 3: Invitation Sent -->
                    <div class="relative flex items-start mb-8">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full flex items-center justify-center 
                            {{ $application->isInvitationSent() ? 'bg-green-100' : 'bg-gray-100' }}">
                            @if($application->isInvitationSent())
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-semibold text-gray-900">Invitation Sent</h3>
                            @if($application->isInvitationSent())
                                <p class="text-gray-600 text-sm">{{ $application->invitation_sent_at->format('M d, Y \a\t g:i A') }}</p>
                                <p class="text-green-600 mt-1">Invitation link has been sent to your email!</p>
                            @else
                                <p class="text-gray-600 mt-1">Once payment is verified, you'll receive an invitation link via email.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Step 4: Account Activated -->
                    <div class="relative flex items-start">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full flex items-center justify-center 
                            {{ $application->isApproved() ? 'bg-green-100' : 'bg-gray-100' }}">
                            @if($application->isApproved())
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-semibold text-gray-900">Account Activated</h3>
                            @if($application->isApproved())
                                <p class="text-gray-600 text-sm">{{ $application->approved_at->format('M d, Y \a\t g:i A') }}</p>
                                <p class="text-green-600 mt-1">Congratulations! Your bidder account is now active.</p>
                            @else
                                <p class="text-gray-600 mt-1">Click the invitation link to activate your bidder account.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Details -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Application Details</h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Name:</span>
                                <p class="font-semibold text-gray-900">{{ $application->user->name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Email:</span>
                                <p class="font-semibold text-gray-900">{{ $application->user->email }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Phone:</span>
                                <p class="font-semibold text-gray-900">{{ $application->phone }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">CNIC:</span>
                                <p class="font-semibold text-gray-900">{{ $application->cnic }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Deposit Amount:</span>
                                <p class="font-semibold text-ubit-purple-600">PKR {{ number_format($application->deposit_amount, 0) }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Bank Name:</span>
                                <p class="font-semibold text-gray-900">{{ $application->bank_name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Account Number:</span>
                                <p class="font-semibold text-gray-900">{{ $application->account_number }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Transaction ID:</span>
                                <p class="font-semibold text-gray-900">{{ $application->transaction_id }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($application->payment_proof)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Proof</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <a href="{{ $application->payment_proof_url }}" target="_blank" class="text-ubit-purple-600 hover:text-ubit-purple-500 font-medium">
                            View Payment Proof →
                        </a>
                    </div>
                </div>
                @endif

                @if($application->admin_notes)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Admin Notes</h3>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-yellow-800">{{ $application->admin_notes }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="text-center">
                @if($application->isApproved())
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-ubit-purple-500 text-white rounded-lg font-semibold hover:bg-ubit-purple-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('auctions.list') }}" class="inline-flex items-center px-6 py-3 bg-gray-500 text-white rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Auctions
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 