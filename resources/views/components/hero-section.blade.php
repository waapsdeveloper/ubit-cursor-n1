<section
    id="hero-section"
    class="relative bg-cover bg-center bg-no-repeat min-h-screen flex items-center"
    style="background-image: url('{{ $backgroundImage }}');">
    
    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"></div>

    <!-- Content Container -->
    <div class="relative container mx-auto px-6 z-10 w-full">
        <div class="flex flex-col lg:flex-row items-center justify-between min-h-screen py-20">
            
            <!-- Left Content Area -->
            <div class="text-white lg:w-1/2 mb-12 lg:mb-0">
                <!-- Badge -->
                @if($badgeText)
                <div class="mb-6">
                    <span class="inline-block bg-ubit-purple-500 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4">
                        {{ $badgeText }}
                    </span>
                </div>
                @endif
                
                <!-- Title -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">
                    {!! $title !!}
                </h1>
                
                <!-- Subtitle -->
                <p class="text-xl md:text-2xl mb-8 text-gray-200 leading-relaxed">
                    {!! $subtitle !!}
                </p>
                
                <!-- Features List -->
                @if(!empty($features))
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    @foreach($features as $feature)
                    <div class="flex items-center text-gray-200">
                        <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ $feature }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Right CTA Area -->
            <div class="lg:w-1/2 flex lg:justify-end">
                <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8 max-w-md w-full">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Ready to Bid?</h3>
                        <p class="text-gray-600">Join exclusive auctions for premium properties</p>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Primary CTA -->
                        <a
                            href="{{ $ctaLink }}"
                            class="w-full bg-gradient-to-r from-ubit-purple-500 to-ubit-purple-600 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:from-ubit-purple-600 hover:to-ubit-purple-500 transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ $ctaText }}
                        </a>
                        
                        <!-- Secondary CTA -->
                        @if($secondaryCtaText)
                        <a
                            href="{{ $secondaryCtaLink }}"
                            class="w-full border-2 border-ubit-purple-500 text-ubit-purple-500 px-8 py-3 rounded-xl font-semibold hover:bg-ubit-purple-500 hover:text-white transition-all duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            {{ $secondaryCtaText }}
                        </a>
                        @endif
                    </div>
                    
                    <!-- Social Proof -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500">
                            <span class="font-semibold text-green-600">✓</span> 
                            Trusted by 500+ bidders
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
        <div class="animate-bounce">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </div>
</section>

<!-- Load Hero Section JavaScript -->
@push('scripts')
<script src="{{ asset('js/components/hero-section.js') }}"></script>
@endpush 