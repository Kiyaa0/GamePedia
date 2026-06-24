@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-8 py-10 text-white">
    
    <div class="mb-6">
        <div class="text-xs font-semibold tracking-widest uppercase text-gray-500">
            GAMES / {{ collect($game['genres'] ?? [])->pluck('name')->first() ?? 'GENRE' }} / <span class="text-red-600">{{ $game['name'] ?? 'UNKNOWN' }}</span>
        </div>
    </div>

    <div class="w-full h-[400px] bg-[#1a1a1a] rounded-lg relative overflow-hidden mb-10 bg-cover bg-center" 
         style="background-image: url('{{ $game['background_image'] ?? '' }}');">
        
        <div class="absolute inset-0 bg-black/40"></div>
        
        <div class="absolute inset-0 opacity-20" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, #E51920 10px, #E51920 12px);"></div>
        
        <div class="absolute bottom-6 left-6 bg-red-600 px-4 py-1 -skew-x-12 z-10">
            <span class="block skew-x-12 text-sm font-bold tracking-wider">NEW UPDATE</span>
        </div>
    </div>

    <div class="flex justify-between items-start mb-8">
        <div>
            <h1 class="text-5xl font-bold uppercase mb-2">{{ $game['name'] ?? 'Loading...' }}</h1>
            <p class="text-sm text-gray-400 font-medium tracking-wide lowercase">
                {{ collect($game['genres'] ?? [])->pluck('name')->implode(' · ') }} · 
                {{ collect($game['platforms'] ?? [])->pluck('platform.name')->implode(' / ') }} · 
                released {{ isset($game['released']) ? \Carbon\Carbon::parse($game['released'])->format('Y') : 'TBA' }}
            </p>
            
            <div class="flex gap-4 mt-8">
                <button class="bg-white text-black font-bold px-8 py-3 rounded-sm flex items-center gap-2 hover:bg-gray-200 transition">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    PLAY NOW
                </button>
                @auth
                    @if ($inWishlist)
                        <button disabled
                            class="border border-green-600 text-green-500 font-bold px-8 py-3 rounded-sm flex items-center gap-2 cursor-default">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            IN WISHLIST
                        </button>
                    @else
                        <form action="{{ route('wishlist.add-from-game', $game['id']) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="border border-gray-600 text-white font-bold px-8 py-3 rounded-sm flex items-center gap-2 hover:bg-[#1a1a1a] transition">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                WISHLIST
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="border border-gray-600 text-white font-bold px-8 py-3 rounded-sm flex items-center gap-2 hover:bg-[#1a1a1a] transition">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        WISHLIST
                    </a>
                @endauth
                <a href="{{ route('forum.index', ['game_id' => $game['id']]) }}"
                    class="border border-gray-600 text-white font-bold px-8 py-3 rounded-sm flex items-center gap-2 hover:bg-[#1a1a1a] transition">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.17L4 17.17V4h16v12z"/></svg>
                    DISKUSI
                </a>
            </div>
        </div>

        <div class="text-right">
            <div class="flex items-baseline justify-end gap-1">
                <span class="text-5xl font-bold text-red-600">{{ $game['rating'] ?? 'N/A' }}</span>
                <span class="text-xl text-gray-500 font-bold">/10</span>
            </div>
            <div class="text-xs text-gray-400 font-bold tracking-widest mt-1">{{ $game['ratings_count'] ?? 0 }} REVIEWS</div>
        </div>
    </div>

    <div class="mt-12">
        <div class="flex gap-8 text-sm font-bold tracking-widest">
            <div class="text-white border-b-2 border-red-600 pb-4">OVERVIEW</div>
            <a href="#media" class="text-gray-500 hover:text-white cursor-pointer pb-4 transition">MEDIA</a>
        </div>
        <div class="border-b border-gray-800 -mt-[2px]"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-16 mt-10">
        
        <div class="md:col-span-2">
            <div class="text-gray-400 leading-relaxed mb-6 text-sm prose prose-invert max-w-none">
                {!! $game['description'] ?? 'Deskripsi tidak tersedia untuk game ini.' !!}
            </div>

            <div id="media" class="mt-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-6 h-[2px] bg-red-600"></div>
                    <h3 class="text-lg font-bold tracking-widest uppercase">MEDIA</h3>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    @forelse($screenshots as $screenshot)
                        <img src="{{ $screenshot['image'] }}" alt="Screenshot"
                            class="w-full rounded-lg object-cover aspect-video">
                    @empty
                        <p class="text-gray-600 text-sm col-span-2">Tidak ada screenshot.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="md:col-span-1">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-6 h-[2px] bg-red-600"></div>
                <h3 class="text-lg font-bold tracking-widest uppercase">DETAILS</h3>
            </div>

            <div class="text-sm">
                <div class="flex justify-between py-3 border-b border-gray-800">
                    <span class="text-gray-500 font-medium">developer</span>
                    <span class="font-bold text-right">{{ collect($game['developers'] ?? [])->pluck('name')->implode(', ') ?: '-' }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-800">
                    <span class="text-gray-500 font-medium">genre</span>
                    <span class="font-bold uppercase text-right">{{ collect($game['genres'] ?? [])->pluck('name')->implode(' / ') ?: '-' }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-800">
                    <span class="text-gray-500 font-medium">platform</span>
                    <span class="font-bold uppercase text-right">{{ collect($game['platforms'] ?? [])->pluck('platform.name')->implode(' / ') ?: '-' }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-800">
                    <span class="text-gray-500 font-medium">publisher</span>
                    <span class="font-bold text-right">{{ collect($game['publishers'] ?? [])->pluck('name')->implode(', ') ?: '-' }}</span>
                </div>

                @php
                    $pcPlat = collect($game['platforms'] ?? [])->firstWhere('platform.slug', 'pc') ?? collect($game['platforms'] ?? [])->first();
                    $rawMin = $pcPlat['requirements']['minimum'] ?? null;
                    $rawRec = $pcPlat['requirements']['recommended'] ?? null;

                    $parse = fn($t) => collect(explode("\n", $t))
                        ->map(fn($l) => preg_replace('/^(Minimum|Recommended)\s*:\s*/i', '', trim($l)))
                        ->filter()
                        ->map(fn($l) => str_contains($l, ':') ? explode(':', $l, 2) : null)
                        ->filter()
                        ->map(fn($p) => ['key' => trim($p[0]), 'val' => trim($p[1])]);
                    $minSpecs = $rawMin ? $parse($rawMin) : collect();
                    $recSpecs = $rawRec ? $parse($rawRec) : collect();
                @endphp

                @foreach([['label' => 'min spec', 'items' => $minSpecs, 'raw' => $rawMin], ['label' => 'req spec', 'items' => $recSpecs, 'raw' => $rawRec]] as $spec)
                    @if($spec['items']->isNotEmpty())
                        <div class="py-3 border-b border-gray-800">
                            <div class="text-gray-500 font-medium text-sm mb-2">{{ $spec['label'] }}</div>
                            <div class="space-y-1">
                                @foreach($spec['items'] as $item)
                                    <div class="flex justify-between text-xs gap-2">
                                        <span class="text-gray-500 shrink-0">{{ $item['key'] }}</span>
                                        <span class="text-gray-300 text-right">{{ $item['val'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @elseif($spec['raw'])
                        <div class="py-3 border-b border-gray-800">
                            <div class="text-gray-500 font-medium text-sm mb-2">{{ $spec['label'] }}</div>
                            <div class="text-gray-400 text-xs leading-relaxed">{!! nl2br(e($spec['raw'])) !!}</div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection