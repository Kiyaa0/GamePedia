@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-8 py-6 md:py-10 text-white">

    {{-- Search Banner --}}
    <div class="bg-[#1a1a1a] rounded-lg py-10 md:py-12 text-center mb-8 md:mb-10 border border-gray-800/50">
        <h1 class="text-2xl md:text-4xl font-bold mb-2">Temukan Game Favoritmu</h1>
        <p class="text-gray-400 text-xs md:text-sm mb-6 md:mb-8 tracking-wide">Database ribuan game dari seluruh dunia</p>

        <form action="{{ route('games.index') }}" method="GET" class="flex justify-center max-w-2xl mx-auto px-4">
            @if (request('genre'))
                <input type="hidden" name="genre" value="{{ request('genre') }}">
            @endif
            @if (request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif

            <input type="text" name="search" placeholder="Cari game..."
                class="w-full bg-[#0f0f11] text-white border border-gray-700 rounded-l-md px-4 md:px-5 py-2.5 md:py-3 text-sm focus:outline-none focus:border-red-600 transition placeholder-gray-600"
                value="{{ request('search') }}">

            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white font-bold px-6 md:px-8 py-2.5 md:py-3 rounded-r-md transition tracking-widest text-sm">
                Cari
            </button>
        </form>
    </div>

    {{-- Genre Filter Bar --}}
    <div class="flex flex-wrap gap-2 mb-6 md:mb-8">
        @php
            $genreIcons = [
                'Action' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L5 5m4.121 4.121L5 5"/></svg>',
                'Adventure' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>',
                'RPG' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>',
                'Shooter' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21l6-6m0 0l-6-6m6 6h12"/></svg>',
                'Strategy' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
                'Racing' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
                'Sports' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v4m0 12v4M2 12h4m12 0h4"/></svg>',
                'Simulation' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
                'Puzzle' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>',
                'Platformer' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>',
                'Fighting' => '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
            ];
            $defaultIcon = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/></svg>';
        @endphp
        <a href="{{ route('games.index', request()->except(['genre', 'page'])) }}"
           class="inline-flex items-center gap-2 px-4 md:px-5 py-2 md:py-2.5 rounded-md text-xs md:text-sm uppercase tracking-widest transition-all duration-300 {{ !request('genre') ? 'bg-[#E51920] text-white font-bold' : 'bg-[#1a1a1a] text-gray-400 border border-gray-800 hover:border-red-600 hover:-translate-y-0.5' }}">
            <svg class="w-3 h-3.5 md:w-3.5 md:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <span>All</span>
        </a>
        @foreach ($genres as $g)
            <a href="{{ route('games.index', array_merge(request()->except('page'), ['genre' => $g['slug']])) }}"
               class="inline-flex items-center gap-2 px-4 md:px-5 py-2 md:py-2.5 rounded-md text-xs md:text-sm uppercase tracking-widest transition-all duration-300 {{ request('genre') === $g['slug'] ? 'bg-[#E51920] text-white font-bold' : 'bg-[#1a1a1a] text-gray-400 border border-gray-800 hover:border-red-600 hover:-translate-y-0.5' }}">
                {!! $genreIcons[$g['name']] ?? $defaultIcon !!}
                <span>{{ $g['name'] }}</span>
            </a>
        @endforeach
    </div>

    {{-- Game Grid --}}
    <div>
            @if (request('search'))
                <p class="text-gray-400 text-xs md:text-sm mb-4 md:mb-6">
                    Hasil pencarian untuk: <span class="text-white font-medium">"{{ request('search') }}"</span>
                </p>
            @endif

            @if (empty($games))
                <div class="text-center py-20 text-gray-500">Game tidak ditemukan.</div>
            @else
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-5 gap-y-10">
                    @foreach ($games as $game)
                        @php
                            $score = $game['metacritic'] ?? null;
                            $badgeColor = $score >= 75 ? 'bg-green-600' : ($score >= 50 ? 'bg-yellow-600' : 'bg-red-600');

                            $platformIcons = [
                                'pc' => '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm0 2v12h16V6H4zm2 2h3v2H6V8zm0 4h3v2H6v-2zm5-4h3v2h-3V8zm0 4h3v2h-3v-2zm5-4h2v2h-2V8zm0 4h2v2h-2v-2z"/></svg>',
                                'playstation' => '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M8.984 2.596v17.548l3.915 1.261V6.688c0-.69.304-1.151.914-1.351.19-.06.456-.121.76-.121.684 0 1.367.361 2.053.991l2.893 2.63 2.201-2.025-3.34-3.035c-.989-.899-2.054-1.483-3.19-1.483-.532 0-1.016.091-1.457.273-1.106.456-1.749 1.403-1.749 2.628zm-2.622 7.489l-3.428 3.13c-.836.762-1.207 1.594-1.111 2.466.087.835.532 1.499 1.293 1.996.455.296 1.015.478 1.642.54.472.045.946.03 1.405-.061.457-.089.872-.232 1.216-.417.172-.093.342-.197.506-.312V10.14c-.228.042-.458.109-.676.202-.397.167-.816.387-1.234.643-.19.116-.371.235-.613.405a9.08 9.08 0 01-.613-.405z"/></svg>',
                                'xbox' => '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M4.38 3.215C2.66 4.852 1.2 7.142.865 9.598c-.43 3.402 1.082 6.709 3.4 8.808L4.38 3.215zm4.512-.19c-1.624 2.78-2.346 5.966-2.346 9.075 0 3.026.66 6.134 2.5 8.82a9.643 9.643 0 002.816-.147c-1.221-1.268-3.48-3.51-4.238-5.461-.89-2.207.691-4.92 1.236-6.183.495-1.155 1.256-2.563 2.548-4.583.114-.182.234-.359.352-.531-1.01-.59-2.893-.876-2.893-.876s.003-.003.025-.114zM12 2.21c-.36.002-.718.069-1.057.206 1.083 1.477 1.822 2.878 2.335 4.196.546 1.402 1.094 3.243.624 4.855-.425 1.473-2.054 3.197-2.954 4.187 1.105 1.141 2.22 1.933 3.352 2.348 4.214-1.451 6.455-5.271 6.455-9.11 0-3.022-1.367-5.864-3.592-7.852 0 0-3.776 1.157-5.163 1.17zm7.837 10.555c.788-1.707.72-3.582.066-5.2l.002-.001.023-.038c.116-.232.187-.39.234-.52 1.102 1.51 1.776 3.326 1.776 5.345 0 2.194-.601 4.118-1.84 5.896 0 0-.602-3.596-2.261-5.482z"/></svg>',
                                'nintendo' => '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M0 6a4 4 0 014-4h16a4 4 0 014 4v12a4 4 0 01-4 4H4a4 4 0 01-4-4V6zm4-2a2 2 0 00-2 2v12a2 2 0 002 2h7V4H4zm15 16a2 2 0 002-2V6a2 2 0 00-2-2h-6v16h6zm-7-14v12h4V4h-4zm-5 2a1 1 0 011 1v6a1 1 0 01-2 0V7a1 1 0 011-1zm3 1a1 1 0 10-2 0v6a1 1 0 102 0V7zm-3 8a1 1 0 011 1v1a1 1 0 01-2 0v-1a1 1 0 011-1z"/></svg>',
                                'ios' => '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.727 2.035c.153 0 .308.008.463.023a.237.237 0 01.204.223c.08 1.135-.303 2.048-.864 2.74-.595.734-1.467 1.33-2.389 1.274a.24.24 0 01-.229-.244c-.023-.964.317-1.904.887-2.618.577-.722 1.464-1.313 1.928-1.398zM18.656 4.985c.614 0 1.198.163 1.691.42 1.235.642 1.763 1.778 1.763 1.778s-.972.448-1.727 1.066c-.754.618-1.264 1.5-1.208 2.526.072 1.326.886 2.153 1.584 2.722.41.334.835.613.835.613s-.471 1.256-1.447 2.16c-1.092 1.01-2.212 1.06-2.968 1.06-.628 0-1.073-.16-1.507-.316-.422-.152-.835-.302-1.368-.302-.571 0-1.054.162-1.539.318-.474.153-.947.306-1.446.306-1.168 0-2.786-.534-3.934-2.248-1.294-1.935-1.577-4.147-1.502-5.073.085-1.049.46-2.002 1.133-2.753.695-.777 1.64-1.265 2.614-1.265.716 0 1.382.257 1.915.457.441.166.808.304 1.125.304.286 0 .641-.134 1.086-.302.62-.234 1.383-.521 2.234-.521z"/></svg>',
                                'android' => '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M7.1 8.8h9.8v6.4H7.1V8.8zm.1 7.8h1.8v3.4c0 .6-.4 1-1 1s-1-.4-1-1v-3.4h.2zm7.9 0H17v3.4c0 .6-.4 1-1 1s-1-.4-1-1v-3.4zm2.8-9.7l1.5-2.6c.1-.2.1-.5-.1-.6-.2-.1-.5-.1-.6.1l-1.5 2.6c-1.2-.7-2.7-1.1-4.2-1.1s-3 .4-4.2 1.1L7.2 4.4c-.1-.2-.4-.3-.6-.1-.2.1-.3.4-.1.6l1.5 2.6c-1.8 1.1-2.9 2.9-2.9 4.9v.6h14v-.6c0-2-1.1-3.8-2.9-4.9zM8.5 7.9c-.4 0-.8-.3-.8-.8s.3-.8.8-.8.8.3.8.8-.3.8-.8.8zm7 0c-.4 0-.8-.3-.8-.8s.3-.8.8-.8.8.3.8.8-.3.8-.8.8z"/></svg>',
                                'macos' => '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M21.982 10.885c-.315-3.144-2.724-5.82-5.64-6.706-.414-.125-1.064-.27-1.966-.405-2.205-.33-4.575-.21-6.868.025-1.058.108-1.806.22-2.242.336-2.448.653-4.307 2.536-4.946 4.964-.134.51-.19 1.03-.19 1.515 0 3.93 2.67 7.258 6.334 8.38.344.105.703.16 1.063.16.345 0 .69-.056 1.033-.167.74-.24 1.47-.558 2.18-.93.712-.372 1.395-.8 2.048-1.28.275-.203.536-.422.78-.657.245-.236.475-.49.685-.757.21-.27.394-.555.55-.857.157-.302.288-.617.395-.943.105-.325.185-.66.242-1.003.124-.763.102-1.528-.034-2.258zM12.25 3.1c.183-1.04.98-1.98 2.064-2.596.004 0 .007-.003.01-.005a.252.252 0 00.042-.352.247.247 0 00-.357-.04 3.216 3.216 0 00-.727.641c-.62.69-1.03 1.567-1.12 2.484 0 .004 0 .008.002.012a.25.25 0 00.278.22.248.248 0 00.22-.276c.007-.064.004-.128-.007-.19z"/></svg>',
                                'linux' => '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 7.5c0 .83-.67 1.5-1.5 1.5S8 10.33 8 9.5 8.67 8 9.5 8s1.5.67 1.5 1.5zm6.5 0c0 .83-.67 1.5-1.5 1.5s-1.5-.67-1.5-1.5.67-1.5 1.5-1.5 1.5.67 1.5 1.5zM12 19c-2.76 0-5-2.24-5-5h10c0 2.76-2.24 5-5 5z"/></svg>',
                            ];

                            $gamePlatforms = collect($game['platforms'] ?? []);
                        @endphp

                        <a href="{{ route('games.show', $game['id']) }}" class="group block">
                            {{-- Card --}}
                            <div class="bg-[#141416] rounded-xl overflow-hidden border border-gray-800/60 hover:border-red-600/40 transition-all duration-300 hover:shadow-[0_0_25px_-5px_rgba(229,25,32,0.15)] hover:-translate-y-1">
                                {{-- Thumbnail --}}
                                <div class="relative aspect-[4/5] bg-[#1a1a1a] overflow-hidden">
                                    <img src="{{ $game['background_image'] ?? 'https://via.placeholder.com/400x250/1a1a1a/666?text=No+Image' }}"
                                        alt="{{ $game['name'] }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                        loading="lazy">

                                    {{-- Gradient Overlay --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#141416] via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                    {{-- Platform Icons --}}
                                    <div class="absolute top-2.5 left-2.5 flex gap-1.5">
                                        @foreach ($gamePlatforms->take(4) as $plat)
                                            @php $slug = $plat['platform']['slug'] ?? ''; @endphp
                                            @if (isset($platformIcons[$slug]))
                                                <span class="bg-black/60 backdrop-blur-sm text-gray-300 p-1.5 rounded-md" title="{{ $plat['platform']['name'] ?? '' }}">
                                                    {!! $platformIcons[$slug] !!}
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>

                                    {{-- Metacritic Badge --}}
                                    @if ($score)
                                        <div class="absolute top-2.5 right-2.5 {{ $badgeColor }} text-white text-[11px] font-bold px-2 py-1 rounded-md shadow-lg">
                                            {{ $score }}
                                        </div>
                                    @endif

                                    {{-- Hover Quick Actions --}}
                                    <div class="absolute inset-x-0 bottom-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                        <span class="block w-full bg-white/10 backdrop-blur-sm text-white text-center text-xs font-bold py-2 rounded-lg border border-white/20 hover:bg-white/20 transition">
                                            Lihat Detail
                                        </span>
                                    </div>
                                </div>

                                {{-- Info --}}
                                <div class="p-3.5">
                                    <h4 class="text-white font-bold text-sm leading-tight group-hover:text-red-500 transition line-clamp-2">
                                        {{ $game['name'] }}
                                    </h4>

                                    <div class="flex items-center justify-between mt-2.5 text-xs">
                                        <span class="text-gray-500 font-medium tracking-wide">{{ substr($game['released'] ?? 'TBA', 0, 4) }}</span>

                                        @if (($game['rating'] ?? 0) > 0)
                                            <span class="flex items-center gap-1 text-gray-400">
                                                <svg class="w-3.5 h-3.5 text-yellow-500 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                </svg>
                                                <span class="font-semibold text-gray-300">{{ number_format($game['rating'] ?? 0, 1) }}</span>
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Genres --}}
                                    @if (count($game['genres'] ?? []) > 0)
                                        <div class="flex flex-wrap gap-1.5 mt-2.5">
                                            @foreach (array_slice($game['genres'] ?? [], 0, 2) as $genre)
                                                <span class="bg-[#1a1a1a] text-gray-500 text-[10px] px-2 py-0.5 rounded-md border border-gray-800 uppercase tracking-wider font-medium">
                                                    {{ $genre['name'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
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
@endsection
