<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GamePedia') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-950 text-white">

    <nav class="bg-gray-900 border-b border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <a href="{{ route('games.index') }}" class="text-lg font-bold text-indigo-400 tracking-tight">GamePedia</a>
            <div class="flex items-center gap-6 text-sm">
                <a href="{{ route('games.index') }}" class="text-gray-400 hover:text-white transition">Browse</a>
                <a href="{{ route('wishlist.index') }}" class="text-gray-400 hover:text-white transition">Wishlist</a>
                <a href="{{ route('forum.index') }}" class="text-gray-400 hover:text-white transition">Forum</a>
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-indigo-600 hover:bg-indigo-700 px-4 py-1.5 rounded-md text-sm text-white transition">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-900/40 border border-green-700 text-green-300 px-4 py-3 rounded-md text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-900/40 border border-red-700 text-red-300 px-4 py-3 rounded-md text-sm">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    <footer class="text-center text-gray-600 text-xs py-6 mt-10 border-t border-gray-800">
        &copy; {{ date('Y') }} GamePedia
    </footer>

</body>
</html>