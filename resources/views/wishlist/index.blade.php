@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- header --}}
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center gap-3">
                <span class="inline-block w-6 h-[2px] bg-red-600"></span>
                <h1 class="text-3xl font-bold lowercase text-white">wishlist saya</h1>
            </div>
            <span class="text-gray-500 uppercase tracking-widest text-sm">{{ $items->count() }} game</span>
        </div>

        @if($items->isEmpty())
            <div class="text-center py-20 text-gray-500">
                <p class="mb-4">Wishlist kamu masih kosong.</p>
                <a href="{{ route('games.index') }}" class="bg-[#E51920] hover:bg-red-600 px-6 py-2.5 rounded text-sm transition">Browse Game</a>
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
