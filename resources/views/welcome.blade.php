@extends('layouts.app')

@section('content')
    {{-- Hero --}}
    <x-landing.hero :games="$heroGames" />

    {{-- Trending Now --}}
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-3">
                    <span class="inline-block w-5 h-px bg-[#E51920]"></span>
                    <h2 class="text-lg font-bold tracking-[0.15em] text-white uppercase">Trending Now</h2>
                </div>
                <a href="{{ route('games.index') }}" class="text-xs text-gray-500 hover:text-white uppercase tracking-widest transition">View All →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($trendingGames as $game)
                    <a href="{{ route('games.show', $game['id']) }}" class="group block">
                        <div class="relative aspect-video bg-[#1a1a1a] overflow-hidden"
                             style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%)">
                            <img src="{{ $game['background_image'] ?? 'https://via.placeholder.com/400x225/1a1a1a/666?text=No+Image' }}"
                                alt="{{ $game['name'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                loading="lazy">
                            <span class="absolute bottom-3 left-3 text-lg font-black text-[#E51920]">{{ number_format($game['rating'], 1) }}</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-sm font-bold tracking-[0.15em] text-white uppercase">{{ $game['name'] }}</h3>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ collect($game['platforms'] ?? [])->pluck('platform.name')->take(3)->implode(' · ') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Berita Game --}}
    @if ($newsItems->isNotEmpty())
        <section class="pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3 mb-10">
                    <span class="inline-block w-5 h-px bg-[#E51920]"></span>
                    <h2 class="text-lg font-bold tracking-[0.15em] text-white uppercase">Berita Game</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($newsItems as $item)
                        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg overflow-hidden">
                            <div class="aspect-video bg-[#0f0f11] overflow-hidden"
                                 style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%)">
                                @if ($item['game_image'])
                                    <img src="{{ $item['game_image'] }}" alt="{{ $item['game_name'] }}"
                                        class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-xs font-bold tracking-widest text-gray-500 uppercase mb-3">{{ $item['game_name'] ?? 'Steam' }}</h3>
                                <div class="space-y-3">
                                    @foreach ($item['news'] as $news)
                                        <a href="{{ $news['url'] }}" target="_blank" rel="noopener noreferrer"
                                            class="block group">
                                            <p class="text-sm font-semibold text-white group-hover:text-[#E51920] transition leading-snug">{{ $news['title'] }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::createFromTimestamp($news['date'])->diffForHumans() }}</p>
                                        </a>
                                        @if (! $loop->last)
                                            <div class="border-t border-white/5"></div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Browse by Genre --}}
    <section class="pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 mb-10">
                <span class="inline-block w-5 h-px bg-[#E51920]"></span>
                <h2 class="text-lg font-bold tracking-[0.15em] text-white uppercase">Browse by Genre</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                @foreach($genres as $genre)
                    <a href="{{ route('games.index', ['genre' => $genre['slug']]) }}"
                        class="bg-[#1a1a1a] hover:bg-[#222] border border-white/5 rounded px-5 py-6 text-center transition group">
                        <p class="text-sm font-bold text-gray-400 group-hover:text-[#E51920] transition uppercase tracking-widest">{{ $genre['name'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
