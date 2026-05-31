<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GamePedia') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-indigo-900 via-purple-900 to-indigo-800">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4 px-6 py-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-5 py-2 text-white border border-white/30 rounded-lg hover:bg-white/10 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-5 py-2 text-white border border-white/30 rounded-lg hover:bg-white/10 transition">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-5 py-2 bg-white text-indigo-900 rounded-lg hover:bg-indigo-50 transition font-semibold">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif

            <div class="flex flex-col items-center justify-center px-6 pt-20 pb-32">
                <div class="text-center max-w-4xl">
                    <h1 class="text-6xl font-extrabold text-white mb-4 tracking-tight">
                        Game<span class="text-indigo-400">Pedia</span>
                    </h1>
                    <p class="text-xl text-indigo-200 mb-8">
                        Your Ultimate Game Encyclopedia & Wishlist Manager
                    </p>
                    <p class="text-lg text-indigo-300/80 mb-12 max-w-2xl mx-auto">
                        Explore thousands of games, build your personal wishlist, and join discussions
                        with fellow gamers. Powered by RAWG.
                    </p>

                    @auth
                        <div class="flex gap-4 justify-center">
                            <a href="{{ route('games.index') }}"
                                class="px-8 py-4 bg-white text-indigo-900 rounded-xl font-bold text-lg hover:bg-indigo-50 transition shadow-xl">
                                Browse Games
                            </a>
                            <a href="{{ route('wishlist.index') }}"
                                class="px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold text-lg hover:bg-indigo-500 transition shadow-xl">
                                My Wishlist
                            </a>
                        </div>
                    @else
                        <div class="flex gap-4 justify-center">
                            <a href="{{ route('register') }}"
                                class="px-8 py-4 bg-white text-indigo-900 rounded-xl font-bold text-lg hover:bg-indigo-50 transition shadow-xl">
                                Get Started
                            </a>
                            <a href="{{ route('login') }}"
                                class="px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold text-lg hover:bg-indigo-500 transition shadow-xl">
                                Sign In
                            </a>
                        </div>
                    @endauth
                </div>

                <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl w-full">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 text-center">
                        <div class="text-4xl mb-4">🎮</div>
                        <h3 class="text-xl font-bold text-white mb-2">Game Encyclopedia</h3>
                        <p class="text-indigo-200">Browse thousands of games with ratings, screenshots, and detailed information from RAWG.</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 text-center">
                        <div class="text-4xl mb-4">⭐</div>
                        <h3 class="text-xl font-bold text-white mb-2">Wishlist Manager</h3>
                        <p class="text-indigo-200">Save games you want to buy, mark what you own, and track what you're currently playing.</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 text-center">
                        <div class="text-4xl mb-4">💬</div>
                        <h3 class="text-xl font-bold text-white mb-2">Community Forum</h3>
                        <p class="text-indigo-200">Discuss your favorite games, share tips, and connect with other gamers.</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
