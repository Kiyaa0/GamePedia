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

    @php
    $user = Auth::user();
@endphp

    <nav x-data="{ open: false }" class="border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="shrink-0 flex items-center gap-3">
                    <div class="w-4 h-6 bg-[#E51920] -skew-x-12"></div>
                    <span class="text-xl font-bold tracking-[0.2em] text-white uppercase">GAMEPEDIA</span>
                </a>

                {{-- Nav Links (Desktop) --}}
                <div class="hidden sm:flex sm:items-center sm:gap-1">
                    <a href="{{ url('/') }}"
                       class="text-sm font-semibold tracking-wide px-4 py-2 rounded-md {{ request()->is('/') ? 'bg-[#E51920] text-white' : 'text-gray-400 hover:text-white transition' }}">
                       HOME
                    </a>
                    <a href="{{ url('/dashboard') }}"
                       class="text-sm font-semibold tracking-wide px-4 py-2 rounded-md {{ request()->is('dashboard*') ? 'bg-[#E51920] text-white' : 'text-gray-400 hover:text-white transition' }}">
                       DASHBOARD
                    </a>
                    <a href="{{ url('/games') }}"
                       class="text-sm font-semibold tracking-wide px-4 py-2 rounded-md {{ request()->is('games*') ? 'bg-[#E51920] text-white' : 'text-gray-400 hover:text-white transition' }}">
                       GAMES
                    </a>
                    <a href="{{ url('/forum') }}"
                       class="text-sm font-semibold tracking-wide px-4 py-2 rounded-md {{ request()->is('forum*') ? 'bg-[#E51920] text-white' : 'text-gray-400 hover:text-white transition' }}">
                       FORUM
                    </a>
                    <a href="{{ url('/wishlist') }}"
                       class="text-sm font-semibold tracking-wide px-4 py-2 rounded-md {{ request()->is('wishlist*') ? 'bg-[#E51920] text-white' : 'text-gray-400 hover:text-white transition' }}">
                       WISHLIST
                    </a>
                </div>

                {{-- Profile Dropdown (Desktop) --}}
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 text-sm font-bold text-gray-400 hover:text-white transition">
                                <span class="w-8 h-8 bg-[#E51920] rounded-full flex items-center justify-center text-xs font-bold text-white">
                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
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
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-white/5">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ url('/') }}"
                   class="block px-4 py-2 text-sm font-semibold tracking-wide rounded-md {{ request()->is('/') ? 'bg-[#E51920] text-white' : 'text-gray-400 hover:text-white transition' }}">
                   HOME
                </a>
                <a href="{{ url('/dashboard') }}"
                   class="block px-4 py-2 text-sm font-semibold tracking-wide rounded-md {{ request()->is('dashboard*') ? 'bg-[#E51920] text-white' : 'text-gray-400 hover:text-white transition' }}">
                   DASHBOARD
                </a>
                <a href="{{ url('/games') }}"
                   class="block px-4 py-2 text-sm font-semibold tracking-wide rounded-md {{ request()->is('games*') ? 'bg-[#E51920] text-white' : 'text-gray-400 hover:text-white transition' }}">
                   GAMES
                </a>
                <a href="{{ url('/forum') }}"
                   class="block px-4 py-2 text-sm font-semibold tracking-wide rounded-md {{ request()->is('forum*') ? 'bg-[#E51920] text-white' : 'text-gray-400 hover:text-white transition' }}">
                   FORUM
                </a>
                <a href="{{ url('/wishlist') }}"
                   class="block px-4 py-2 text-sm font-semibold tracking-wide rounded-md {{ request()->is('wishlist*') ? 'bg-[#E51920] text-white' : 'text-gray-400 hover:text-white transition' }}">
                   WISHLIST
                </a>
                <div class="border-t border-white/5 my-2"></div>
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 text-sm font-semibold tracking-wide rounded-md text-gray-400 hover:text-white transition">
                   Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm font-semibold tracking-wide rounded-md text-gray-400 hover:text-white transition">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
