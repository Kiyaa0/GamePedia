<x-app-layout>
    <div class="mb-4">
        <a href="{{ route('games.index') }}" class="text-gray-400 hover:text-white text-sm transition">Kembali</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kiri --}}
        <div class="lg:col-span-2">
            @if($game['background_image'])
                <img src="{{ $game['background_image'] }}" alt="{{ $game['name'] }}"
                    class="w-full rounded-lg mb-6 object-cover max-h-80">
            @endif

            <h1 class="text-3xl font-bold mb-3">{{ $game['name'] }}</h1>

            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($game['genres'] ?? [] as $genre)
                    <span class="bg-indigo-600/20 text-indigo-400 text-xs px-3 py-1 rounded-full border border-indigo-600/30">{{ $genre['name'] }}</span>
                @endforeach
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-3 text-center">
                    <p class="text-xs text-gray-400">Rating</p>
                    <p class="font-bold text-yellow-400">{{ $game['rating'] ?? '-' }}</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-3 text-center">
                    <p class="text-xs text-gray-400">Rilis</p>
                    <p class="font-bold text-sm">{{ \Carbon\Carbon::parse($game['released'] ?? null)->format('Y') ?? '-' }}</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-3 text-center">
                    <p class="text-xs text-gray-400">Playtime</p>
                    <p class="font-bold text-sm">{{ $game['playtime'] ?? '-' }} jam</p>
                </div>
                @if($game['metacritic'] ?? false)
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-3 text-center">
                        <p class="text-xs text-gray-400">Metacritic</p>
                        <p class="font-bold text-green-400">{{ $game['metacritic'] }}</p>
                    </div>
                @endif
            </div>

            <div class="text-gray-300 text-sm leading-relaxed mb-8">
                {!! $game['description_raw'] ?? 'Deskripsi tidak tersedia.' !!}
            </div>

            {{-- PC Requirements --}}
            @php $pc = collect($game['platforms'] ?? [])->firstWhere('platform.slug', 'pc'); @endphp
            @if($pc && !empty($pc['requirements']['minimum']))
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-5 mb-6">
                    <h3 class="font-semibold text-indigo-400 mb-3">PC Requirements</h3>
                    <div class="text-xs text-gray-400 leading-relaxed mb-3 whitespace-pre-wrap font-mono bg-gray-950 p-3 rounded">{{ $pc['requirements']['minimum'] }}</div>
                    @if(!empty($pc['requirements']['recommended']))
                        <h4 class="font-medium text-gray-300 mb-2 text-sm">Recommended</h4>
                        <div class="text-xs text-gray-400 leading-relaxed whitespace-pre-wrap font-mono bg-gray-950 p-3 rounded">{{ $pc['requirements']['recommended'] }}</div>
                    @endif
                </div>
            @endif

            {{-- Screenshots --}}
            @if(!empty($screenshots))
                <h3 class="font-semibold mb-3">Screenshots</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach(array_slice($screenshots, 0, 6) as $ss)
                        <img src="{{ $ss['image'] }}" alt="Screenshot"
                            class="rounded-lg object-cover aspect-video w-full cursor-pointer hover:opacity-80 transition"
                            onclick="window.open('{{ $ss['image'] }}', '_blank')">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Kanan --}}
        <div>
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-5 sticky top-24 space-y-4">

                {{-- Wishlist --}}
                <div>
                    <h3 class="font-semibold mb-3 text-sm">Tambah ke Wishlist</h3>
                    @auth
                        @if($inWishlist)
                            <div class="bg-green-900/30 border border-green-700 text-green-400 text-xs px-3 py-2 rounded-md mb-3">
                                Sudah ada di wishlist kamu
                            </div>
                            <a href="{{ route('wishlist.index') }}" class="block w-full text-center bg-gray-700 hover:bg-gray-600 py-2 rounded-md text-sm transition">
                                Lihat Wishlist
                            </a>
                        @else
                            <form method="POST" action="{{ route('wishlist.add-from-game', $game['id']) }}">
                                @csrf
                                <button class="w-full bg-indigo-600 hover:bg-indigo-700 py-2 rounded-md text-sm font-medium transition">
                                    Tambah ke Wishlist
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 py-2 rounded-md text-sm transition">Login untuk Wishlist</a>
                    @endauth
                </div>

                {{-- Game Info --}}
                <div class="border-t border-gray-800 pt-4 space-y-2 text-sm">
                    @if($game['developers'] ?? false)
                        <div class="flex justify-between">
                            <span class="text-gray-400">Developer</span>
                            <span class="text-right text-xs">{{ collect($game['developers'])->pluck('name')->join(', ') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-400">Platform</span>
                        <span class="text-right text-xs">{{ collect($game['platforms'] ?? [])->pluck('platform.name')->join(', ') }}</span>
                    </div>
                </div>

                {{-- Forum --}}
                <div class="border-t border-gray-800 pt-4">
                    <a href="{{ route('forum.index', ['game_id' => $game['id']]) }}"
                        class="block w-full text-center bg-gray-800 hover:bg-gray-700 py-2 rounded-md text-sm transition">
                        Lihat Forum Diskusi
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>