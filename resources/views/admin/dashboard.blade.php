@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Admin Panel</h1>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-400 hover:text-white transition">Manajemen User &rarr;</a>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-400 hover:text-white transition">&larr; Kembali ke Dashboard</a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-5">
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Total User</p>
            <p class="text-3xl font-bold text-white">{{ $totalUsers }}</p>
        </div>
        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-5">
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Total Wishlist</p>
            <p class="text-3xl font-bold text-blue-400">{{ $totalWishlisted }}</p>
        </div>
        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-5">
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Game Dimiliki</p>
            <p class="text-3xl font-bold text-green-400">{{ $totalOwned }}</p>
        </div>
    </div>

    <div class="space-y-6">
        @foreach($users as $user)
            <div class="bg-[#1a1a1a] border border-white/5 rounded-lg overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 bg-[#222] border-b border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-[#222] rounded-full flex items-center justify-center text-xs font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-sm">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500">
                        {{ $user->wishlistItems->count() }} game
                        ({{ $user->wishlistItems->where('status', 'owned')->count() }} owned)
                    </span>
                </div>

                @if($user->wishlistItems->isEmpty())
                    <div class="p-5 text-center text-gray-600 text-sm">
                        Belum ada wishlist.
                    </div>
                @else
                    <div class="divide-y divide-white/5">
                        @foreach($user->wishlistItems as $item)
                            <div class="flex items-center gap-3 px-5 py-3">
                                <img src="{{ $item->game_image ?? 'https://via.placeholder.com/60x34?text=N/A' }}"
                                    alt="{{ $item->game_title }}"
                                    class="w-12 h-8 object-cover rounded shrink-0">
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('games.show', $item->rawg_game_id) }}"
                                        class="text-sm hover:text-[#E51920] transition truncate block">{{ $item->game_title }}</a>
                                    @if($item->notes)
                                        <p class="text-xs text-gray-500 truncate">{{ $item->notes }}</p>
                                    @endif
                                </div>
                                <span class="text-xs px-2 py-0.5 rounded shrink-0
                                    {{ $item->status === 'owned' ? 'bg-green-900/50 text-green-400' :
                                       ($item->status === 'playing' ? 'bg-blue-900/50 text-blue-400' :
                                       'bg-yellow-900/50 text-yellow-400') }}">
                                    {{ $item->status === 'owned' ? 'Owned' : ($item->status === 'playing' ? 'Playing' : 'Want to Buy') }}
                                </span>
                                <span class="text-xs text-gray-600 w-20 text-right">{{ $item->created_at->format('d M Y') }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
