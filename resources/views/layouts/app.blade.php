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
<body class="font-sans antialiased bg-[#0b0c2a] text-white">

    @include('layouts.navigation')

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

    <footer class="text-center text-gray-600 text-xs py-6 mt-10 border-t border-[#2a2a2a]">
        &copy; {{ date('Y') }} GamePedia
    </footer>

    @stack('scripts')
</body>
</html>
