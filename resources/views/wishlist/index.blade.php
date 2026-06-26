@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 md:px-8 py-6 md:py-10">

        {{-- header --}}
        <div class="flex items-center justify-between mb-6 md:mb-12">
            <div class="flex items-center gap-2 md:gap-3">
                <span class="inline-block w-4 md:w-6 h-[2px] bg-red-600"></span>
                <h1 class="text-xl md:text-3xl font-bold lowercase text-white">wishlist saya</h1>
            </div>
            <span class="text-gray-500 uppercase tracking-widest text-[11px] md:text-sm">{{ $items->count() }} game</span>
        </div>

        @if($items->isEmpty())
            <div class="text-center py-16 md:py-20 text-gray-500">
                <p class="mb-4 text-sm md:text-base">Wishlist kamu masih kosong.</p>
                <a href="{{ route('games.index') }}" class="bg-[#E51920] hover:bg-red-600 px-5 md:px-6 py-2 md:py-2.5 rounded text-xs md:text-sm transition">Browse Game</a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($items as $item)
                    <x-game-card :item="$item" />
                @endforeach
            </div>

            <div class="mt-10">{{ $items->links() }}</div>
        @endif

    </div>
@endsection
