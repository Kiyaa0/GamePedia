@extends('layouts.app')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-3">
        <h1 class="text-xl md:text-2xl font-bold">Admin Panel</h1>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">Manajemen User &rarr;</a>
            <a href="{{ route('dashboard') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">&larr; Kembali ke Dashboard</a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4 mb-6 md:mb-8">
        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-4 md:p-5">
            <p class="text-[10px] md:text-xs text-gray-400 uppercase tracking-widest mb-2">Total User</p>
            <p class="text-2xl md:text-3xl font-bold text-white">{{ $totalUsers }}</p>
        </div>
        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-4 md:p-5">
            <p class="text-[10px] md:text-xs text-gray-400 uppercase tracking-widest mb-2">Total Wishlist</p>
            <p class="text-2xl md:text-3xl font-bold text-blue-400">{{ $totalWishlisted }}</p>
        </div>
        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-4 md:p-5">
            <p class="text-[10px] md:text-xs text-gray-400 uppercase tracking-widest mb-2">Game Dimiliki</p>
            <p class="text-2xl md:text-3xl font-bold text-green-400">{{ $totalOwned }}</p>
        </div>
    </div>

    <div class="space-y-4 md:space-y-6">
        @foreach($users as $user)
            <div class="bg-[#1a1a1a] border border-white/5 rounded-lg overflow-hidden">
                <div class="flex items-center justify-between px-4 md:px-5 py-3 md:py-4 bg-[#222] border-b border-white/5 gap-2">
                    <div class="flex items-center gap-2 md:gap-3 min-w-0">
                        <div class="w-7 h-7 md:w-8 md:h-8 bg-[#222] rounded-full flex items-center justify-center text-[10px] md:text-xs font-bold shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-medium text-xs md:text-sm truncate">{{ $user->name }}</p>
                            <p class="text-[10px] md:text-xs text-gray-500 truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="text-[10px] md:text-xs text-gray-500 shrink-0">
                        {{ $user->wishlistItems->count() }} game
                    </span>
                </div>

                @if($user->wishlistItems->isEmpty())
                    <div class="p-4 md:p-5 text-center text-gray-600 text-sm">
                        Belum ada wishlist.
                    </div>
                @else
                    <div class="divide-y divide-white/5">
                        @foreach($user->wishlistItems as $item)
                            <div class="flex items-center gap-2 md:gap-3 px-4 md:px-5 py-2.5 md:py-3">
                                <img src="{{ $item->game_image ?? 'https://via.placeholder.com/60x34?text=N/A' }}"
                                    alt="{{ $item->game_title }}"
                                    class="w-10 h-7 md:w-12 md:h-8 object-cover rounded shrink-0">
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('games.show', $item->rawg_game_id) }}"
                                        class="text-xs md:text-sm hover:text-[#E51920] transition truncate block">{{ $item->game_title }}</a>
                                    @if($item->notes)
                                        <p class="text-[10px] md:text-xs text-gray-500 truncate">{{ $item->notes }}</p>
                                    @endif
                                </div>
                                <span class="text-[10px] md:text-xs px-1.5 md:px-2 py-0.5 rounded shrink-0
                                    {{ $item->status === 'owned' ? 'bg-green-900/50 text-green-400' :
                                       ($item->status === 'playing' ? 'bg-blue-900/50 text-blue-400' :
                                       'bg-yellow-900/50 text-yellow-400') }}">
                                    {{ $item->status === 'owned' ? 'Owned' : ($item->status === 'playing' ? 'Playing' : 'Want') }}
                                </span>
                                <span class="text-[10px] md:text-xs text-gray-600 hidden md:block w-20 text-right">{{ $item->created_at->format('d M Y') }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
