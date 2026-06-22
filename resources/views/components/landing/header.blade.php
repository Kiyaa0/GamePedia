<header x-data="{ open: false }" class="bg-[#070720]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <div class="shrink-0">
                <a href="/" class="text-xl font-bold tracking-tight text-white">
                    <span class="text-red-500">Game</span>Pedia
                </a>
            </div>

            <nav class="hidden lg:flex items-center">
                <ul class="flex items-center gap-1">
                    <li>
                        <a href="/" class="px-4 py-2 text-sm font-bold text-white bg-red-500 rounded-md transition">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('games.index') }}" class="px-4 py-2 text-sm font-bold text-gray-400 hover:text-white transition">Browse</a>
                    </li>
                    <li>
                        <a href="{{ route('forum.index') }}" class="px-4 py-2 text-sm font-bold text-gray-400 hover:text-white transition">Forum</a>
                    </li>
                    <li>
                        <a href="{{ route('wishlist.index') }}" class="px-4 py-2 text-sm font-bold text-gray-400 hover:text-white transition">Wishlist</a>
                    </li>
                </ul>
            </nav>

            <div class="hidden lg:flex items-center gap-6">
                <a href="{{ route('games.index') }}" class="text-white hover:text-red-500 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-white hover:text-red-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-red-500 hover:bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-md transition">Login</a>
                @endauth
            </div>

            <button @click="open = !open" class="lg:hidden text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <div x-cloak x-show="open" @click.outside="open = false" class="lg:hidden border-t border-[#2a2a2a]">
        <div class="px-4 py-4 space-y-1">
            <a href="/" class="block px-3 py-2 text-sm font-bold text-white bg-red-500 rounded-md">Home</a>
            <a href="{{ route('games.index') }}" class="block px-3 py-2 text-sm font-bold text-gray-400 hover:text-white transition">Browse</a>
            <a href="{{ route('forum.index') }}" class="block px-3 py-2 text-sm font-bold text-gray-400 hover:text-white transition">Forum</a>
            <a href="{{ route('wishlist.index') }}" class="block px-3 py-2 text-sm font-bold text-gray-400 hover:text-white transition">Wishlist</a>
            <div class="flex items-center gap-4 px-3 pt-3 border-t border-[#2a2a2a]">
                <a href="{{ route('games.index') }}" class="text-gray-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-red-400 font-bold hover:text-red-300">Login</a>
                @endauth
            </div>
        </div>
    </div>
</header>
