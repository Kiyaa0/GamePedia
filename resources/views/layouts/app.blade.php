<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GAMEPEDIA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .nav-link {
            position: relative;
            padding-bottom: 2px;
            transition: color 0.2s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #dc2626;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .nav-link.active::after {
            width: 100%;
        }
        .nav-link .nav-label {
            transition: color 0.2s ease;
        }
        .nav-link:hover .nav-label {
            color: #ffffff;
        }
    </style>
</head>
<body class="bg-[#0f0f11] text-white font-sans antialiased">

    @php
    $user = Auth::user();
@endphp

    <nav x-data="{ open: false }" class="bg-[#0f0f11] border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="shrink-0 flex items-center gap-3">
                    <div class="w-4 h-6 bg-red-600 -skew-x-12"></div>
                    <span class="text-xl font-bold tracking-widest text-white">GAMEPEDIA</span>
                </a>

                {{-- Nav Links (Desktop) --}}
                <div class="hidden sm:flex sm:items-center sm:gap-6">
                    @php
                        $menuItems = [
                            ['label' => 'HOME', 'url' => url('/'), 'active' => request()->is('/')],
                            ['label' => 'DASHBOARD', 'url' => url('/dashboard'), 'active' => request()->is('dashboard*')],
                            ['label' => 'GAMES', 'url' => url('/games'), 'active' => request()->is('games*') && !request()->is('wishlist*')],
                            ['label' => 'FORUM', 'url' => url('/forum'), 'active' => request()->is('forum*') || request()->is('replies*')],
                            ['label' => 'WISHLIST', 'url' => url('/wishlist'), 'active' => request()->is('wishlist*')],
                        ];

                        if ($user && $user->role === 'admin') {
                            $menuItems[] = ['label' => 'ADMIN', 'url' => url('/admin'), 'active' => request()->is('admin*')];
                        }
                    @endphp

                    @foreach ($menuItems as $item)
                        <a href="{{ $item['url'] }}"
                            class="nav-link {{ $item['active'] ? 'active' : '' }} text-sm uppercase tracking-widest">
                            <span class="nav-label font-bold
                                {{ $item['active'] ? 'text-white' : 'text-gray-400' }}">
                                {{ $item['label'] }}
                            </span>
                        </a>
                    @endforeach
                </div>

                {{-- Auth (Desktop) --}}
                <div class="hidden sm:flex sm:items-center">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2 text-sm font-bold text-gray-400 hover:text-white transition">
                                    <span class="w-8 h-8 bg-[#E51920] rounded-full flex items-center justify-center text-xs font-bold text-white">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
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
                    @else
                        <div class="flex items-center gap-4">
                            <a href="{{ route('login') }}" class="text-xs font-bold text-gray-400 hover:text-white uppercase tracking-widest transition">Sign In</a>
                            <a href="{{ route('register') }}" class="text-xs font-bold bg-[#E51920] text-white px-4 py-2 hover:bg-red-600 uppercase tracking-widest transition">Sign Up</a>
                        </div>
                    @endauth
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
                @foreach ($menuItems as $item)
                    <a href="{{ $item['url'] }}"
                        class="block px-4 py-2 text-sm font-bold uppercase tracking-widest rounded-md transition
                            {{ $item['active'] ? 'bg-red-600 text-white' : 'text-gray-400 hover:text-white' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                @auth
                    <div class="border-t border-white/5 my-2"></div>
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm font-bold tracking-widest rounded-md text-gray-400 hover:text-white transition">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm font-bold tracking-widest rounded-md text-gray-400 hover:text-white transition">
                            Log Out
                        </button>
                    </form>
                @else
                    <div class="border-t border-white/5 my-2"></div>
                    <a href="{{ route('login') }}"
                        class="block px-4 py-2 text-sm font-bold tracking-widest rounded-md text-gray-400 hover:text-white transition">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                        class="block px-4 py-2 text-sm font-bold tracking-widest rounded-md bg-[#E51920] text-white hover:bg-red-600 transition mt-2">
                        Sign Up
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="bg-red-900/50 border border-red-800 text-red-300 px-6 py-3 rounded text-sm">
                {{ session('error') }}
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="bg-green-900/50 border border-green-800 text-green-300 px-6 py-3 rounded text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
