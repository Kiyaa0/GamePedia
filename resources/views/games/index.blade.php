<x-app-layout>
    {{-- Hero Search --}}
    <div class="bg-gradient-to-b from-gray-900 to-gray-950 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-10 mb-8">
        <h1 class="text-3xl font-bold text-center mb-2">Temukan Game Favoritmu</h1>
        <p class="text-gray-400 text-center text-sm mb-6">Database ribuan game dari seluruh dunia</p>
        <form action="{{ route('games.index') }}" method="GET" class="max-w-2xl mx-auto flex gap-2">
            @if(request('genre')) <input type="hidden" name="genre" value="{{ request('genre') }}"> @endif
            @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
            <input type="text" name="search" placeholder="Cari game..." value="{{ request('search') }}"
                class="flex-1 bg-gray-800 border border-gray-600 rounded-md px-5 py-3 text-sm text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
            <button class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-md text-sm font-medium transition">Cari</button>
        </form>
    </div>

    <div class="flex gap-8">
        {{-- Sidebar Filter --}}
        <div class="w-48 shrink-0 hidden lg:block">
            <div class="sticky top-24">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Genre</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('games.index', request()->except('genre')) }}"
                            class="block px-3 py-2 rounded text-sm transition {{ !request('genre') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            Semua Genre
                        </a>
                    </li>
                    @foreach($genres as $g)
                        <li>
                            <a href="{{ route('games.index', array_merge(request()->all(), ['genre' => $g['slug']])) }}"
                                class="block px-3 py-2 rounded text-sm transition {{ request('genre') === $g['slug'] ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                {{ $g['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3 mt-6">Urutkan</p>
                <ul class="space-y-1">
                    @php $sorts = ['-rating' => 'Rating Tertinggi', '-released' => 'Terbaru', '-added' => 'Terpopuler', 'name' => 'A-Z']; @endphp
                    @foreach($sorts as $key => $label)
                        <li>
                            <a href="{{ route('games.index', array_merge(request()->all(), ['sort' => $key])) }}"
                                class="block px-3 py-2 rounded text-sm transition {{ ($sortBy ?? '-rating') === $key ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Game Grid --}}
        <div class="flex-1">
            @if(request('search'))
                <p class="text-gray-400 text-sm mb-4">Hasil pencarian untuk: <span class="text-white font-medium">"{{ request('search') }}"</span></p>
            @endif

            @if(empty($games))
                <div class="text-center py-20 text-gray-500">Game tidak ditemukan.</div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($games as $game)
                        <a href="{{ route('games.show', $game['id']) }}"
                            class="bg-gray-900 border border-gray-800 hover:border-blue-500 rounded-lg overflow-hidden transition group block">
                            <div class="relative aspect-video overflow-hidden">
                                <img src="{{ $game['background_image'] ?? 'https://via.placeholder.com/300x170?text=No+Image' }}"
                                    alt="{{ $game['name'] }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                    loading="lazy">
                                @if($game['metacritic'] ?? false)
                                    <span class="absolute top-2 right-2 text-xs font-bold px-1.5 py-0.5 rounded
                                        {{ $game['metacritic'] >= 75 ? 'bg-green-600' : ($game['metacritic'] >= 50 ? 'bg-yellow-600' : 'bg-red-600') }}">
                                        {{ $game['metacritic'] }}
                                    </span>
                                @endif
                            </div>
                            <div class="p-3">
                                <p class="text-sm font-semibold truncate group-hover:text-blue-400 transition">{{ $game['name'] }}</p>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs text-gray-500">{{ substr($game['released'] ?? '-', 0, 4) }}</span>
                                    <span class="text-xs text-yellow-400">{{ number_format($game['rating'] ?? 0, 1) }}</span>
                                </div>
                                <div class="flex flex-wrap gap-1 mt-2">
                                    @foreach(array_slice($game['genres'] ?? [], 0, 2) as $genre)
                                        <span class="text-xs bg-gray-800 text-gray-400 px-2 py-0.5 rounded">{{ $genre['name'] }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($total > 20)
                    <div class="flex justify-center gap-3 mt-10">
                        @if($currentPage > 1)
                            <a href="{{ route('games.index', array_merge(request()->all(), ['page' => $currentPage - 1])) }}"
                                class="bg-gray-800 hover:bg-gray-700 px-6 py-2.5 rounded-md text-sm transition">Sebelumnya</a>
                        @endif
                        <span class="bg-gray-900 border border-gray-700 px-4 py-2.5 rounded-md text-sm text-gray-400">
                            Halaman {{ $currentPage }}
                        </span>
                        @if($currentPage < ceil($total / 20))
                            <a href="{{ route('games.index', array_merge(request()->all(), ['page' => $currentPage + 1])) }}"
                                class="bg-blue-600 hover:bg-blue-700 px-6 py-2.5 rounded-md text-sm transition">Selanjutnya</a>
                        @endif
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>