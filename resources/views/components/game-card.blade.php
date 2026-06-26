@props(['item'])

@php
    $statusConfig = [
        'owned' => ['badge' => 'bg-green-500', 'text' => 'text-green-400', 'label' => 'Owned'],
        'playing' => ['badge' => 'bg-blue-500', 'text' => 'text-blue-400', 'label' => 'Playing'],
        'want_to_buy' => ['badge' => 'bg-yellow-500', 'text' => 'text-yellow-400', 'label' => 'Want to Buy'],
    ];
    $cfg = $statusConfig[$item->status] ?? $statusConfig['want_to_buy'];
@endphp

<div class="group relative">
    <div class="bg-[#141416] rounded-lg md:rounded-xl overflow-hidden border border-gray-800/60 transition-all duration-500 group-hover:border-red-600/40 group-hover:shadow-2xl group-hover:shadow-black/60 group-hover:-translate-y-2.5">

        {{-- Image --}}
        <div class="relative aspect-[3/4] bg-[#1a1a1a] overflow-hidden">
            <img src="{{ $item->game_image ?? 'https://via.placeholder.com/300x400/1a1a1a/666?text=No+Image' }}"
                alt="{{ $item->game_title }}"
                class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out"
                loading="lazy">

            {{-- Bottom Gradient Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-[#1a1a1a] via-transparent to-transparent"></div>

            {{-- Desktop: Hover Actions Overlay --}}
            <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px] opacity-0 md:group-hover:opacity-100 transition-opacity duration-300 hidden md:flex flex-col items-center justify-center gap-3 p-4">

                <form method="POST" action="{{ route('wishlist.update', $item) }}" class="w-full">
                    @csrf @method('PATCH')
                    <select name="status" onchange="this.form.submit()"
                        class="w-full bg-white/10 border border-white/20 text-white text-xs font-bold py-2.5 px-3 rounded-lg appearance-none cursor-pointer focus:outline-none focus:border-red-500 transition text-center uppercase tracking-widest backdrop-blur-sm">
                        <option value="want_to_buy" {{ $item->status === 'want_to_buy' ? 'selected' : '' }} class="text-gray-900">Want to Buy</option>
                        <option value="playing" {{ $item->status === 'playing' ? 'selected' : '' }} class="text-gray-900">Playing</option>
                        <option value="owned" {{ $item->status === 'owned' ? 'selected' : '' }} class="text-gray-900">Owned</option>
                    </select>
                </form>

                <form method="POST" action="{{ route('wishlist.destroy', $item) }}"
                    onsubmit="return confirm('Hapus dari wishlist?')" class="w-full">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-600/80 hover:bg-red-600 text-white text-xs font-bold py-2.5 rounded-lg transition tracking-widest uppercase backdrop-blur-sm">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- Info Section --}}
        <div class="p-3 md:p-4">
            <a href="{{ route('games.show', $item->rawg_game_id) }}">
                <h4 class="text-white font-bold text-xs md:text-sm leading-tight group-hover:text-red-500 transition lowercase line-clamp-2">
                    {{ $item->game_title }}
                </h4>
            </a>

            <div class="flex items-center gap-2 mt-1.5 md:mt-2">
                <span class="inline-block w-2.5 h-2.5 md:w-[14px] md:h-[14px] -skew-x-12 {{ $cfg['badge'] }}"></span>
                <span class="text-[9px] md:text-[10px] font-bold uppercase tracking-widest {{ $cfg['text'] }}">
                    {{ $cfg['label'] }}
                </span>
            </div>

            {{-- Mobile: Actions below info --}}
            <div class="flex md:hidden flex-col gap-1.5 mt-2.5">
                <form method="POST" action="{{ route('wishlist.update', $item) }}">
                    @csrf @method('PATCH')
                    <select name="status" onchange="this.form.submit()"
                        class="w-full bg-[#1a1a1a] border border-gray-800 text-white text-[10px] font-bold py-2 px-2.5 rounded-md appearance-none cursor-pointer focus:outline-none focus:border-red-500 transition uppercase tracking-widest text-center">
                        <option value="want_to_buy" {{ $item->status === 'want_to_buy' ? 'selected' : '' }} class="text-gray-900">Want to Buy</option>
                        <option value="playing" {{ $item->status === 'playing' ? 'selected' : '' }} class="text-gray-900">Playing</option>
                        <option value="owned" {{ $item->status === 'owned' ? 'selected' : '' }} class="text-gray-900">Owned</option>
                    </select>
                </form>

                <form method="POST" action="{{ route('wishlist.destroy', $item) }}"
                    onsubmit="return confirm('Hapus dari wishlist?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-600/20 hover:bg-red-600/40 text-red-500 text-[10px] font-bold py-2 rounded-md transition tracking-widest uppercase">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
