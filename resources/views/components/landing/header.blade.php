<header x-data="{ open: false }" class="bg-[#0f0f11] border-b border-white/5 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">

            {{-- Logo --}}
            <div class="shrink-0 flex items-center gap-3">
                <span class="inline-block w-5 h-5 bg-[#E51920] -skew-x-12"></span>
                <a href="/" class="text-lg font-bold tracking-[0.2em] text-white">GAMEPEDIA</a>
            </div>

            {{-- Nav Desktop --}}
            <nav class="hidden lg:flex items-center gap-8">
                <a href="/" class="text-sm font-bold uppercase tracking-widest text-white border-b-2 border-[#E51920] pb-1">Home</a>
                <a href="{{ route('games.index') }}" class="text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-white transition pb-1">Games</a>
                <a href="{{ route('forum.index') }}" class="text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-white transition pb-1">Forum</a>
            </nav>

            {{-- Right --}}
            <div class="hidden lg:flex items-center gap-6">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-white hover:text-[#E51920] transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold uppercase tracking-widest text-white bg-[#E51920] hover:bg-red-600 px-5 py-2 rounded transition">Login</a>
                @endauth
                <button class="text-gray-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            {{-- Hamburger Mobile --}}
            <button @click="open = !open" class="lg:hidden text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-cloak x-show="open" @click.outside="open = false" class="lg:hidden border-t border-white/5">
        <div class="px-4 py-4 space-y-1">
            <a href="/" class="block px-3 py-2 text-sm font-bold uppercase tracking-widest text-white">Home</a>
            <a href="{{ route('games.index') }}" class="block px-3 py-2 text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-white transition">Games</a>
            <a href="{{ route('forum.index') }}" class="block px-3 py-2 text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-white transition">Forum</a>
            <div class="pt-3 mt-3 border-t border-white/5 flex items-center gap-4 px-3">
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
                    <a href="{{ route('login') }}" class="text-sm font-bold text-[#E51920] hover:text-red-400">Login</a>
                @endauth
            </div>
        </div>
    </div>
</header>
