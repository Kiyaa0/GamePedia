@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-8 py-10 text-white">

    {{-- Search Banner --}}
    <div class="bg-[#1a1a1a] rounded-lg py-12 text-center mb-10 border border-gray-800/50">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Temukan Game Favoritmu</h1>
        <p class="text-gray-400 text-sm mb-8 tracking-wide">Database ribuan game dari seluruh dunia</p>

        <form action="{{ route('games.index') }}" method="GET" class="flex justify-center max-w-2xl mx-auto px-4">
            @if (request('genre'))
                <input type="hidden" name="genre" value="{{ request('genre') }}">
            @endif
            @if (request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif

            <input type="text" name="search" placeholder="Cari game..."
                class="w-full bg-[#0f0f11] text-white border border-gray-700 rounded-l-md px-5 py-3 focus:outline-none focus:border-red-600 transition placeholder-gray-600"
                value="{{ request('search') }}">

            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3 rounded-r-md transition tracking-widest">
                Cari
            </button>
        </form>
    </div>

    {{-- Main Content --}}
    <div class="flex flex-col md:flex-row gap-10">

        {{-- Sidebar Genre --}}
        <aside class="w-full md:w-56 flex-shrink-0">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-4 h-[2px] bg-red-600"></div>
                <h3 class="text-xs font-bold tracking-widest uppercase text-gray-500">GENRE</h3>
            </div>

            <div class="flex flex-col gap-1">
                <a href="{{ route('games.index', request()->except(['genre', 'page'])) }}"
                    class="{{ !request('genre') ? 'bg-red-600 text-white' : 'text-gray-400 hover:text-white hover:bg-[#1a1a1a]' }} font-bold px-4 py-2.5 rounded-md text-sm transition">
                    Semua Genre
                </a>

                @foreach ($genres as $g)
                    <a href="{{ route('games.index', array_merge(request()->except('page'), ['genre' => $g['slug']])) }}"
                        class="{{ request('genre') === $g['slug'] ? 'bg-red-600 text-white' : 'text-gray-400 hover:text-white hover:bg-[#1a1a1a]' }} px-4 py-2.5 rounded-md text-sm transition">
                        {{ $g['name'] }}
                    </a>
                @endforeach
            </div>

            {{-- Sorting --}}
            <div class="flex items-center gap-3 mb-4 mt-8">
                <div class="w-4 h-[2px] bg-red-600"></div>
                <h3 class="text-xs font-bold tracking-widest uppercase text-gray-500">URUTKAN</h3>
            </div>

            <div class="flex flex-col gap-1">
                @php $sorts = ['-rating' => 'Rating Tertinggi', '-released' => 'Terbaru', '-added' => 'Terpopuler', 'name' => 'A-Z']; @endphp
                @foreach ($sorts as $key => $label)
                    <a href="{{ route('games.index', array_merge(request()->except('page'), ['sort' => $key])) }}"
                        class="{{ ($sortBy ?: '-rating') === $key ? 'bg-red-600 text-white' : 'text-gray-400 hover:text-white hover:bg-[#1a1a1a]' }} px-4 py-2.5 rounded-md text-sm transition">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </aside>

        {{-- Game Grid --}}
        <div class="flex-1">
            @if (request('search'))
                <p class="text-gray-400 text-sm mb-6">
                    Hasil pencarian untuk: <span class="text-white font-medium">"{{ request('search') }}"</span>
                </p>
            @endif

            @if (empty($games))
                <div class="text-center py-20 text-gray-500">Game tidak ditemukan.</div>
            @else
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10">
                    @foreach ($games as $game)
                        <a href="{{ route('games.show', $game['id']) }}" class="group block cursor-pointer">

                            {{-- Thumbnail --}}
                            <div class="relative aspect-[16/10] bg-[#1a1a1a] rounded-md overflow-hidden mb-3 border border-gray-800/50">
                                <img src="{{ $game['background_image'] ?? 'https://via.placeholder.com/400x250/1a1a1a/666?text=No+Image' }}"
                                    alt="{{ $game['name'] }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                    loading="lazy">

                                {{-- Score Badge --}}
                                @php
                                    $score = $game['metacritic'] ?? null;
                                    $badgeColor = $score >= 75 ? 'bg-green-600' : ($score >= 50 ? 'bg-yellow-600' : 'bg-red-600');
                                @endphp
                                @if ($score)
                                    <div class="absolute bottom-2 left-2 {{ $badgeColor }} text-white text-[11px] font-bold px-2 py-1 rounded-sm shadow-lg">
                                        {{ $score }}
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <h4 class="text-white font-bold text-sm truncate group-hover:text-red-500 transition">
                                {{ $game['name'] }}
                            </h4>

                            <div class="flex justify-between items-center text-xs text-gray-500 mt-1 font-medium tracking-wide">
                                <span>{{ substr($game['released'] ?? '-', 0, 4) }}</span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3 text-yellow-500 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                    {{ number_format($game['rating'] ?? 0, 1) }}
                                </span>
                            </div>

                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach (array_slice($game['genres'] ?? [], 0, 2) as $genre)
                                    <span class="bg-[#1a1a1a] text-gray-400 text-[10px] px-2 py-1 rounded border border-gray-800 uppercase tracking-wider">
                                        {{ $genre['name'] }}
                                    </span>
                                @endforeach
                            </div>

                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($total > 20)
                    <div class="flex justify-center gap-3 mt-12">
                        @if ($currentPage > 1)
                            <a href="{{ route('games.index', array_merge(request()->except('page'), ['page' => $currentPage - 1])) }}"
                                class="bg-[#1a1a1a] hover:bg-[#222] text-gray-400 px-6 py-2.5 rounded-md text-sm transition">
                                Sebelumnya
                            </a>
                        @endif

                        <span class="bg-[#1a1a1a] border border-gray-800 px-4 py-2.5 rounded-md text-sm text-gray-400">
                            {{ $currentPage }}
                        </span>

                        @if ($currentPage < ceil($total / 20))
                            <a href="{{ route('games.index', array_merge(request()->except('page'), ['page' => $currentPage + 1])) }}"
                                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-md text-sm transition">
                                Selanjutnya
                            </a>
                        @endif
                    </div>
                @endif
            @endif
        </div>

    </div>
</div>
@endsection
