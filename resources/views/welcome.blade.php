@extends('layouts.app')

@section('content')
    {{-- Hero --}}
    <x-landing.hero />

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
                @php
                    $trending = [
                        ['title' => 'Crimson Veil', 'rating' => '9.2', 'platform' => 'pc · ps5', 'img' => 'https://via.placeholder.com/400x225/1a1a1a/fff?text=CV'],
                        ['title' => 'Neon Dynasty', 'rating' => '8.8', 'platform' => 'pc · xbox', 'img' => 'https://via.placeholder.com/400x225/1a1a1a/fff?text=ND'],
                        ['title' => 'Starfall Legacy', 'rating' => '9.5', 'platform' => 'pc · ps5 · xbox', 'img' => 'https://via.placeholder.com/400x225/1a1a1a/fff?text=SL'],
                    ];
                @endphp
                @foreach($trending as $game)
                    <a href="{{ route('games.index') }}" class="group block">
                        <div class="relative aspect-video bg-[#1a1a1a] overflow-hidden"
                             style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%)">
                            <img src="{{ $game['img'] }}" alt="{{ $game['title'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                loading="lazy">
                            <span class="absolute bottom-3 left-3 text-lg font-black text-[#E51920]">{{ $game['rating'] }}</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-sm font-bold tracking-[0.15em] text-white uppercase">{{ $game['title'] }}</h3>
                            <p class="text-xs text-gray-500 mt-1">{{ $game['platform'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

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
