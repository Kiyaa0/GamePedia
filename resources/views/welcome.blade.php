<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GamePedia</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white font-sans antialiased min-h-screen flex flex-col items-center justify-center px-4">

    <h1 class="text-4xl font-bold mb-2 tracking-tight">GamePedia</h1>
    <p class="text-gray-400 text-sm mb-10">Ensiklopedia & Wishlist Game Favoritmu</p>

    <div class="w-full max-w-xs space-y-3">
        @auth
            <a href="{{ route('games.index') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-md font-medium transition">
                Browse Games
            </a>
            <a href="{{ url('/dashboard') }}" class="block w-full bg-gray-800 hover:bg-gray-700 text-white text-center py-3 rounded-md font-medium transition">
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-md font-medium transition">
                Login
            </a>
            <a href="{{ route('register') }}" class="block w-full bg-gray-800 hover:bg-gray-700 text-white text-center py-3 rounded-md font-medium transition">
                Register
            </a>
        @endauth
    </div>

    <p class="text-gray-600 text-xs mt-10">&copy; {{ date('Y') }} GamePedia</p>

</body>
</html>