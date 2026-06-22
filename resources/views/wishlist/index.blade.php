<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
            <span class="inline-block w-[14px] h-[1px] bg-[#e21c1c]"></span>
            <h1 class="text-2xl font-bold">Wishlist Saya</h1>
        </div>
        <span class="text-gray-400 text-sm">{{ $items->count() }} game</span>
    </div>

    @if($items->isEmpty())
        <div class="text-center py-20 text-gray-500">
            <p class="mb-4">Wishlist kamu masih kosong.</p>
            <a href="{{ route('games.index') }}" class="bg-red-500 hover:bg-red-600 px-6 py-2.5 rounded-md text-sm transition">Browse Game</a>
        </div>
    @else
        {{-- grid with gap-px for hairline separators --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-px bg-[#2a2a2a] rounded-lg overflow-hidden">
            @foreach($items as $item)
                <div class="bg-gray-900 overflow-hidden"
                     style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 8px), calc(100% - 8px) 100%, 0 100%)">
                    <a href="{{ route('games.show', $item->rawg_game_id) }}">
                        <img src="{{ $item->game_image ?? 'https://via.placeholder.com/300x170?text=No+Image' }}"
                            alt="{{ $item->game_title }}"
                            class="w-full aspect-video object-cover hover:opacity-80 transition">
                    </a>
                    <div class="p-4">
                        <a href="{{ route('games.show', $item->rawg_game_id) }}"
                            class="font-semibold text-sm hover:text-red-400 transition block truncate">{{ $item->game_title }}</a>

                        <div class="mt-1 mb-3">
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $item->status === 'owned' ? 'bg-green-900/50 text-green-400 border border-green-800' :
                                   ($item->status === 'playing' ? 'bg-blue-900/50 text-blue-400 border border-blue-800' :
                                   'bg-yellow-900/50 text-yellow-400 border border-yellow-800') }}">
                                {{ $item->status_label }}
                            </span>
                        </div>

                        <form method="POST" action="{{ route('wishlist.update', $item) }}">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                class="w-full bg-gray-800 border border-[#2a2a2a] rounded-md px-3 py-1.5 text-xs text-white mb-3 focus:outline-none focus:border-red-500">
                                <option value="want_to_buy" {{ $item->status === 'want_to_buy' ? 'selected' : '' }}>Want to Buy</option>
                                <option value="owned" {{ $item->status === 'owned' ? 'selected' : '' }}>Owned</option>
                                <option value="playing" {{ $item->status === 'playing' ? 'selected' : '' }}>Playing</option>
                            </select>
                        </form>

                        <form method="POST" action="{{ route('wishlist.destroy', $item) }}"
                            onsubmit="return confirm('Hapus dari wishlist?')">
                            @csrf @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 text-xs transition">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $items->links() }}</div>
    @endif
</x-app-layout>
