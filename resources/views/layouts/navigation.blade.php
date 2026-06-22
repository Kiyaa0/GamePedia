<nav x-data="{ open: false }" class="bg-[#070720] border-b border-[#2a2a2a] sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="text-lg font-bold tracking-tight text-white">
                    <span class="text-red-500">Game</span>Pedia
                </a>
            </div>

            {{-- Nav Links (Desktop) --}}
            <div class="hidden sm:flex sm:items-center sm:gap-1">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link :href="route('games.index')" :active="request()->routeIs('games.*') && !request()->routeIs('wishlist.*')">
                    {{ __('Games') }}
                </x-nav-link>
                <x-nav-link :href="route('forum.index')" :active="request()->routeIs('forum.*') || request()->routeIs('replies.*')">
                    {{ __('Forum') }}
                </x-nav-link>
                <x-nav-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.*')">
                    {{ __('Wishlist') }}
                </x-nav-link>
            </div>

            {{-- Profile Dropdown (Desktop) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 text-sm font-bold text-gray-400 hover:text-white transition">
                            <span class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-xs font-bold text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger (Mobile) --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-[#2a2a2a]">
        <div class="px-4 py-4 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('games.index')" :active="request()->routeIs('games.*') && !request()->routeIs('wishlist.*')">
                {{ __('Games') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('forum.index')" :active="request()->routeIs('forum.*') || request()->routeIs('replies.*')">
                {{ __('Forum') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.*')">
                {{ __('Wishlist') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-3 border-t border-[#2a2a2a]">
            <div class="flex items-center gap-3 px-4 mb-3">
                <span class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center text-sm font-bold text-white">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                <div class="text-sm">
                    <p class="font-medium text-white">{{ Auth::user()->name }}</p>
                    <p class="text-gray-500">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="space-y-1 px-4">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
