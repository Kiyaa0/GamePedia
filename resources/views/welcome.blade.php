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
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="flex flex-col items-center justify-center min-h-screen px-6 py-12">
            <img class="size-20 rounded-full mb-4" src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y" alt="avatar">
            <h1 class="text-lg font-semibold mb-8">{{ config('app.name', 'GamePedia') }}</h1>

            <div class="w-full max-w-sm space-y-3">
                @auth
                    <a href="{{ route('games.index') }}" class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-center text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                        Browse Games
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-center text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                        My Wishlist
                    </a>
                    <a href="{{ url('/dashboard') }}" class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-center text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-center text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-center text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </body>
</html>
