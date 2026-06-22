<x-layouts.game>
    <x-landing.hero />

    {{-- Trending Games --}}
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 mb-8">
                <span class="inline-block w-[14px] h-[1px] bg-[#e21c1c]"></span>
                <h2 class="text-xl font-bold text-white">Trending Now</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-px bg-[#2a2a2a] rounded-lg overflow-hidden">
                @php
                    $trending = [
                        ['title' => 'Elden Ring', 'year' => '2022', 'rating' => '4.8', 'genre' => 'RPG', 'img' => 'https://via.placeholder.com/300x170/1a1a2e/fff?text=ER'],
                        ['title' => 'God of War Ragnarök', 'year' => '2022', 'rating' => '4.9', 'genre' => 'Action', 'img' => 'https://via.placeholder.com/300x170/16213e/fff?text=GOW'],
                        ['title' => 'Zelda: Tears of Kingdom', 'year' => '2023', 'rating' => '5.0', 'genre' => 'Adventure', 'img' => 'https://via.placeholder.com/300x170/0f3460/fff?text=Zelda'],
                        ['title' => 'Cyberpunk 2077', 'year' => '2020', 'rating' => '4.2', 'genre' => 'RPG', 'img' => 'https://via.placeholder.com/300x170/1a1a2e/fff?text=CP77'],
                        ['title' => 'Red Dead Redemption 2', 'year' => '2018', 'rating' => '4.9', 'genre' => 'Action', 'img' => 'https://via.placeholder.com/300x170/16213e/fff?text=RDR2'],
                        ['title' => 'The Witcher 3', 'year' => '2015', 'rating' => '4.8', 'genre' => 'RPG', 'img' => 'https://via.placeholder.com/300x170/0f3460/fff?text=TW3'],
                    ];
                @endphp
                @foreach($trending as $game)
                    <a href="{{ route('games.index') }}"
                        class="bg-gray-900 hover:bg-gray-800/80 transition block group"
                        style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 6px), calc(100% - 6px) 100%, 0 100%)">
                        <div class="relative aspect-video overflow-hidden">
                            <img src="{{ $game['img'] }}" alt="{{ $game['title'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                loading="lazy">
                            <span class="absolute bottom-2 left-2 text-xs font-bold px-1.5 py-0.5 rounded bg-red-600 text-white">
                                {{ $game['rating'] }}
                            </span>
                        </div>
                        <div class="p-3">
                            <p class="text-sm font-semibold truncate group-hover:text-red-400 transition">{{ $game['title'] }}</p>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-xs text-gray-500">{{ $game['year'] }}</span>
                                <span class="text-xs text-gray-500">{{ $game['genre'] }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Categories --}}
    <section class="pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 mb-8">
                <span class="inline-block w-[14px] h-[1px] bg-[#e21c1c]"></span>
                <h2 class="text-xl font-bold text-white">Browse by Genre</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                @php
                    $genres = ['Action', 'RPG', 'Adventure', 'Strategy', 'Simulation', 'Sports'];
                @endphp
                @foreach($genres as $genre)
                    <a href="{{ route('games.index', ['genre' => strtolower($genre)]) }}"
                        class="bg-gray-900 hover:bg-gray-800 border border-[#2a2a2a] rounded-lg px-5 py-6 text-center transition group">
                        <p class="text-sm font-bold text-gray-300 group-hover:text-red-400 transition">{{ $genre }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="text-center text-gray-600 text-xs py-6 border-t border-[#2a2a2a]">
        &copy; {{ date('Y') }} GamePedia. All rights reserved.
    </footer>
</x-layouts.game>
