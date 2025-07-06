<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Real Estate Auction</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Landing Navigation -->
            <nav class="bg-ubit-purple-500 border-b border-ubit-purple-600">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('landing') }}">
                                    <x-application-logo class="block h-9 w-auto fill-current text-white" />
                                </a>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden sm:flex sm:items-center sm:space-x-8">
                            <a href="#how" class="text-white hover:text-ubit-yellow-300 px-3 py-2 rounded-md text-sm font-medium transition-colors">How it Works</a>
                            <a href="#auctions" class="text-white hover:text-ubit-yellow-300 px-3 py-2 rounded-md text-sm font-medium transition-colors">Auctions</a>
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-ubit-yellow-300 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-white hover:text-ubit-yellow-300 px-3 py-2 rounded-md text-sm font-medium transition-colors">Logout</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-white hover:text-ubit-yellow-300 px-3 py-2 rounded-md text-sm font-medium transition-colors">Login</a>
                                <a href="{{ route('register') }}" class="bg-white text-ubit-purple-500 px-4 py-2 rounded-md text-sm font-medium hover:bg-ubit-yellow-300 hover:text-ubit-purple-500 transition-colors">Register</a>
                            @endauth
                        </div>

                        <!-- Mobile menu button -->
                        <div class="sm:hidden flex items-center">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-ubit-yellow-300 hover:bg-ubit-purple-600 focus:outline-none focus:bg-ubit-purple-600 focus:text-ubit-yellow-300 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div x-show="mobileMenuOpen" class="sm:hidden bg-ubit-purple-600">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="#how" class="text-white hover:text-ubit-yellow-300 block px-3 py-2 rounded-md text-base font-medium transition-colors">How it Works</a>
                        <a href="#auctions" class="text-white hover:text-ubit-yellow-300 block px-3 py-2 rounded-md text-base font-medium transition-colors">Auctions</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-ubit-yellow-300 block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="text-white hover:text-ubit-yellow-300 block px-3 py-2 rounded-md text-base font-medium w-full text-left transition-colors">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-ubit-yellow-300 block px-3 py-2 rounded-md text-base font-medium transition-colors">Login</a>
                            <a href="{{ route('register') }}" class="bg-white text-ubit-purple-500 block px-3 py-2 rounded-md text-base font-medium hover:bg-ubit-yellow-300 transition-colors">Register</a>
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Alpine.js for mobile menu -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </body>
</html> 