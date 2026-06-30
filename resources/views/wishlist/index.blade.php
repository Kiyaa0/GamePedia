@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-8 py-4 md:py-10">

    <div
        x-data="{ loaded: false }"
        x-init="setTimeout(() => loaded = true, 100)"
        class="flex items-center justify-between mb-8 md:mb-12"
        :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
        style="transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1)">

        <div class="flex items-center gap-3">
            <div class="w-1 h-8 bg-[#e21c1c] relative overflow-hidden">
                <span class="absolute inset-0 bg-red-400 animate-pulse"></span>
            </div>
            <div>
                <h1 class="text-2xl md:text-4xl font-bold text-white tracking-tight uppercase">Wishlist</h1>
            </div>
        </div>
        <span class="text-[10px] md:text-xs text-gray-400 font-bold tracking-widest">{{ $stats['total'] }} GAMES</span>
    </div>

    @php
        $currentFilter = request('status', '');
        $tabs = ['' => 'All', 'want_to_buy' => 'Want to Buy', 'playing' => 'Playing', 'owned' => 'Owned'];
    @endphp

    <div
        x-data="{ loaded: false }"
        x-init="setTimeout(() => loaded = true, 200)"
        :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
        style="transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1)"
        class="flex items-center gap-1 mb-6 md:mb-8 overflow-x-auto pb-2">

        @foreach($tabs as $key => $label)
            @php
                $count = $key === '' ? $stats['total'] : ($stats[$key] ?? 0);
                $isActive = $currentFilter === $key;
                $url = $key === '' ? route('wishlist.index') : route('wishlist.index', ['status' => $key]);
            @endphp
            <a href="{{ $url }}"
                class="shrink-0 px-5 py-2.5 text-xs md:text-sm font-bold uppercase tracking-widest transition-all duration-300 border-b-2
                {{ $isActive
                    ? 'text-white border-[#e21c1c]'
                    : 'text-gray-400 border-transparent hover:text-white hover:border-gray-600' }}">
                {{ $label }}
                <span class="ml-1.5 text-gray-600">{{ $count }}</span>
            </a>
        @endforeach
    </div>

    <div
        x-data="{ loaded: false }"
        x-init="setTimeout(() => loaded = true, 300)"
        :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
        style="transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1)"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        @forelse($items as $item)
            <x-game-card :item="$item" :index="$loop->index" />
        @empty
            <div class="col-span-full border border-gray-800 bg-[#0a0a0a] py-16 md:py-24 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-[#e21c1c]/20 mb-6">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-[#e21c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>
                <p class="text-gray-300 text-sm font-bold uppercase tracking-widest mb-2">Empty</p>
                <p class="text-gray-500 text-xs uppercase tracking-widest mb-8">Belum ada game tersimpan.</p>
                <a href="{{ route('games.index') }}"
                    class="inline-flex items-center gap-2 bg-[#e21c1c] hover:bg-red-700 text-white font-bold px-8 py-3 text-xs uppercase tracking-[0.2em] transition-all duration-300 hover:shadow-lg hover:shadow-[#e21c1c]/30 active:scale-95">
                    Cari Game
                </a>
            </div>
        @endforelse
    </div>

    @if($items->hasPages())
        <div class="mt-10">
            {{ $items->withQueryString()->links() }}
        </div>
    @endif

</div>
@endsection
