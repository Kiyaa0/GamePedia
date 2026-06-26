@extends('layouts.app')

@section('content')
    {{-- Hero --}}
    <x-landing.hero :games="$heroGames" />

    {{-- Trending Now --}}
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-6 h-[2px] bg-red-600"></span>
                    <h2 class="text-white font-bold uppercase tracking-widest text-base">Trending Now</h2>
                </div>
                <a href="{{ route('games.index') }}" class="text-xs text-gray-500 hover:text-white uppercase tracking-widest transition">View All →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($trendingGames as $game)
                    <a href="{{ route('games.show', $game['id']) }}" class="group block cursor-pointer">
                        <div class="relative aspect-video overflow-hidden
                                    [clip-path:polygon(0_8px,8px_0,100%_0,100%_calc(100%-8px),calc(100%-8px)_100%,8px_100%,0_calc(100%-8px))]
                                    shadow-[0_0_0_1px_rgba(229,25,32,0.25)]
                                    group-hover:shadow-[0_0_20px_rgba(229,25,32,0.5)]
                                    transition-shadow duration-500">
                            <div class="absolute inset-0 bg-[#1a1a1a]">
                                <img src="{{ $game['background_image'] ?? 'https://via.placeholder.com/400x225/1a1a1a/666?text=No+Image' }}"
                                    alt="{{ $game['name'] }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy">
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                                 style="background: linear-gradient(135deg, rgba(229,25,32,0.15) 0%, transparent 50%, rgba(229,25,32,0.05) 100%);">
                            </div>
                            <span class="absolute top-2 right-2 w-1.5 h-1.5 rounded-full bg-red-600 shadow-[0_0_6px_rgba(229,25,32,0.8)]"></span>
                            <span class="absolute bottom-3 left-3 text-red-500 font-bold text-lg drop-shadow-[0_0_6px_rgba(229,25,32,0.6)]">{{ number_format($game['rating'], 1) }}</span>
                            <span class="absolute bottom-3 right-3 text-[8px] text-red-400/50 font-mono uppercase tracking-[0.2em]">● LIVE</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-sm font-bold text-white uppercase truncate group-hover:text-red-500 transition-colors">{{ $game['name'] }}</h3>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ collect($game['platforms'] ?? [])->pluck('platform.name')->take(3)->implode(' · ') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Berita Game + Browse by Genre --}}
    @php
        $genreIcons = [
            'Action' => '<svg class="w-8 h-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L5 5m4.121 4.121L5 5"/></svg>',
            'RPG' => '<svg class="w-8 h-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
            'Strategy' => '<svg class="w-8 h-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
            'Racing' => '<svg class="w-8 h-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
            'Sports' => '<svg class="w-8 h-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2v4m0 12v4M2 12h4m12 0h4"/></svg>',
            'Simulation' => '<svg class="w-8 h-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
        ];
        $defaultIcon = '<svg class="w-8 h-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/></svg>';
        $featuredGenres = ['Action', 'RPG'];
    @endphp

    <div class="max-w-7xl mx-auto px-8 mt-12">
        {{-- Berita Game --}}
        @if ($newsItems->isNotEmpty())
            @php
                $featuredGame = $newsItems->first();
                $allNews = collect();
                foreach ($newsItems as $item) {
                    foreach ($item['news'] as $news) {
                        $allNews->push([
                            'title' => $news['title'],
                            'url' => $news['url'],
                            'date' => $news['date'],
                            'game_name' => $item['game_name'] ?? 'Steam',
                            'game_image' => $item['game_image'] ?? null,
                        ]);
                    }
                }
                $featuredNews = $allNews->first();
                $restNews = $allNews->skip(1)->take(5);
            @endphp

            <section>
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-1 h-5 bg-[#E51920]"></span>
                        <h2 class="text-white font-bold uppercase tracking-widest text-base">BERITA GAME</h2>
                    </div>
                    <a href="#" class="text-sm text-gray-400 hover:text-white transition">Lihat semua berita →</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    {{-- Featured News (Left) --}}
                    <div class="md:col-span-8 group">
                        <div class="relative overflow-hidden"
                             style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 20px 100%, 0 calc(100% - 20px))">
                            <img src="{{ $featuredGame['game_image'] ?? 'https://via.placeholder.com/800x450/1a1a1a/666?text=No+Image' }}"
                                 alt="{{ $featuredGame['game_name'] }}"
                                 class="w-full aspect-[16/9] object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0f0f11] via-[#0f0f11]/60 to-transparent"></div>
                        </div>
                        <div class="mt-5 pl-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="inline-block w-1 h-3 bg-[#E51920]"></span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $featuredGame['game_name'] }}</span>
                            </div>
                            <h3 class="text-3xl font-bold text-white leading-tight lowercase">{{ $featuredNews['title'] }}</h3>
                            <p class="text-xs text-gray-500 mt-3">{{ \Carbon\Carbon::createFromTimestamp($featuredNews['date'])->diffForHumans() }}</p>
                        </div>
                    </div>

                    {{-- Sidebar News (Right) --}}
                    <div class="md:col-span-4 flex flex-col">
                        @foreach ($restNews as $news)
                            <a href="{{ $news['url'] }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center gap-4 py-4 border-l-4 border-transparent group hover:border-l-4 hover:border-red-600 transition-all duration-300 pl-3 {{ !$loop->first ? 'border-t border-gray-800' : '' }}">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-white group-hover:text-red-500 transition-colors duration-300 leading-snug lowercase">{{ $news['title'] }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::createFromTimestamp($news['date'])->diffForHumans() }}</p>
                                </div>
                                <div class="w-20 h-16 flex-shrink-0 overflow-hidden bg-gray-800"
                                     style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 6px), calc(100% - 6px) 100%, 0 100%)">
                                    @if ($news['game_image'])
                                        <img src="{{ $news['game_image'] }}" alt="{{ $news['game_name'] }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Browse by Genre --}}
        @if ($genres->isNotEmpty())
            <section class="mt-12 pb-20">
                <div class="flex items-center gap-2 mb-8">
                    <span class="inline-block w-1 h-5 bg-[#E51920]"></span>
                    <h2 class="text-white font-bold uppercase tracking-widest text-base">BROWSE BY GENRE</h2>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($genres as $genre)
                        @php
                            $isFeatured = in_array($genre['name'], $featuredGenres);
                            $icon = $genreIcons[$genre['name']] ?? $defaultIcon;
                        @endphp
                        <a href="{{ route('games.index', ['genre' => $genre['slug']]) }}"
                            class="bg-[#1a1a1a] border border-transparent rounded-md flex flex-col items-center justify-center p-8 hover:border-[#E51920] hover:-translate-y-1 hover:scale-[1.02] transition-all duration-300 {{ $isFeatured ? 'md:col-span-2 md:row-span-2' : '' }}">
                            {!! $icon !!}
                            <span class="text-white font-bold uppercase text-sm">{{ $genre['name'] }}</span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
