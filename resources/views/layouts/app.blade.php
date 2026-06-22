<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GAMEPEDIA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0f0f11] text-white font-sans antialiased">

    <nav class="flex items-center justify-between px-8 py-4 border-b border-white/5">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="w-4 h-6 bg-[#E51920] -skew-x-12"></div>
            <span class="text-xl font-bold tracking-[0.2em] text-white uppercase">GAMEPEDIA</span>
        </a>

        <div class="flex items-center gap-8 text-sm font-semibold tracking-wide">
            <a href="{{ url('/') }}"
               class="{{ request()->is('/') ? 'bg-[#E51920] text-white px-4 py-2 rounded-md' : 'text-gray-400 hover:text-white transition' }}">
               HOME
            </a>
            <a href="{{ url('/dashboard') }}"
               class="{{ request()->is('dashboard*') ? 'bg-[#E51920] text-white px-4 py-2 rounded-md' : 'text-gray-400 hover:text-white transition' }}">
               DASHBOARD
            </a>
            <a href="{{ url('/games') }}"
               class="{{ request()->is('games*') ? 'bg-[#E51920] text-white px-4 py-2 rounded-md' : 'text-gray-400 hover:text-white transition' }}">
               GAMES
            </a>
            <a href="{{ url('/forum') }}"
               class="{{ request()->is('forum*') ? 'bg-[#E51920] text-white px-4 py-2 rounded-md' : 'text-gray-400 hover:text-white transition' }}">
               FORUM
            </a>
            <a href="{{ url('/wishlist') }}"
               class="{{ request()->is('wishlist*') ? 'bg-[#E51920] text-white px-4 py-2 rounded-md' : 'text-gray-400 hover:text-white transition' }}">
               WISHLIST
            </a>
        </div>

        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-[#E51920] flex items-center justify-center text-white text-sm font-bold">
                U
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
