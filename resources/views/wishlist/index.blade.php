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
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($items as $item)
                    <!-- kartu wishlist -->
                    <div class="bg-[#0a0a0a] overflow-hidden">

                        <a href="{{ route('games.show', $item->rawg_game_id) }}">
                            <div class="aspect-video bg-[#1a1a1a]"
                                style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%)">
                                <img src="{{ $item->game_image ?? 'https://via.placeholder.com/300x170?text=No+Image' }}"
                                    alt="{{ $item->game_title }}"
                                    class="w-full h-full object-cover hover:opacity-80 transition">
                            </div>
                        </a>

                        <div class="mt-4 px-1">
                            <a href="{{ route('games.show', $item->rawg_game_id) }}"
                                class="font-bold text-white text-[15px] lowercase block truncate hover:text-red-500 transition">
                                {{ $item->game_title }}
                            </a>

                            {{-- status badge — warna dinamis: 'owned' → hijau, 'want-to-buy' → kuning, 'playing' → biru --}}
                            <div class="flex items-center gap-2 mt-2 mb-3">
                                <span class="inline-block w-2 h-3 -skew-x-12
                                    {{ $item->status === 'owned' ? 'bg-green-500' : ($item->status === 'want_to_buy' ? 'bg-yellow-500' : 'bg-blue-500') }}">
                                </span>
                                <span class="text-[10px] font-bold uppercase tracking-widest
                                    {{ $item->status === 'owned' ? 'text-green-500' : ($item->status === 'want_to_buy' ? 'text-yellow-500' : 'text-blue-500') }}">
                                    {{ $item->status_label }}
                                </span>
                            </div>

                            <form method="POST" action="{{ route('wishlist.update', $item) }}">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="w-full bg-[#0f0f11] border border-gray-800 rounded-sm px-3 py-2 text-sm text-gray-300 lowercase focus:outline-none focus:border-red-600 transition">
                                    <option value="want_to_buy" {{ $item->status === 'want_to_buy' ? 'selected' : '' }}>want to buy</option>
                                    <option value="playing" {{ $item->status === 'playing' ? 'selected' : '' }}>playing</option>
                                    <option value="owned" {{ $item->status === 'owned' ? 'selected' : '' }}>owned</option>
                                </select>
                            </form>

                            <form method="POST" action="{{ route('wishlist.destroy', $item) }}"
                                onsubmit="return confirm('Hapus dari wishlist?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:text-red-400 text-xs font-bold uppercase tracking-widest mt-3 transition">
                                    hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">{{ $items->links() }}</div>
        @endif

    </div>
@endsection
