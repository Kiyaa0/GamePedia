<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('games.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">&larr; Back to Games</a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-1">{{ $game['name'] }}</h2>
            </div>
            <div class="flex gap-2">
                <form action="{{ route('wishlist.add-from-game', $game['id']) }}" method="POST">
                    @csrf
                    <x-primary-button>Add to Wishlist</x-primary-button>
                </form>
                <a href="{{ route('forum.create', ['game_id' => $game['id']]) }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                    Discuss
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($game['background_image'])
                        <img src="{{ $game['background_image'] }}" alt="{{ $game['name'] }}"
                            class="w-full h-96 object-cover rounded-lg mb-6">
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2">
                            <div class="prose max-w-none mb-6">
                                {!! $game['description_raw'] ?? 'No description available.' !!}
                            </div>

                            @php
                                $pcPlatform = collect($game['platforms'] ?? [])->firstWhere('platform.slug', 'pc');
                            @endphp

                            @if ($pcPlatform && !empty($pcPlatform['requirements']['minimum']))
                                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                    <h3 class="font-semibold text-gray-900 mb-3">PC Minimum Specifications</h3>
                                    <div class="text-sm text-gray-700 whitespace-pre-wrap font-mono bg-white p-3 rounded border">
                                        {{ $pcPlatform['requirements']['minimum'] }}
                                    </div>
                                    @if (!empty($pcPlatform['requirements']['recommended']))
                                        <h4 class="font-semibold text-gray-900 mt-4 mb-2">Recommended Specifications</h4>
                                        <div class="text-sm text-gray-700 whitespace-pre-wrap font-mono bg-white p-3 rounded border">
                                            {{ $pcPlatform['requirements']['recommended'] }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900 mb-3">Game Info</h3>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Rating</dt>
                                        <dd class="text-gray-900">⭐ {{ $game['rating'] ?? 'N/A' }} / 5</dd>
                                    </div>
                                    @if ($game['released'] ?? false)
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Released</dt>
                                            <dd class="text-gray-900">{{ \Carbon\Carbon::parse($game['released'])->format('M d, Y') }}</dd>
                                        </div>
                                    @endif
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Genres</dt>
                                        <dd class="text-gray-900 text-right">
                                            @foreach ($game['genres'] ?? [] as $genre)
                                                <span>{{ $genre['name'] }}{{ !$loop->last ? ', ' : '' }}</span>
                                            @endforeach
                                        </dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Platforms</dt>
                                        <dd class="text-gray-900 text-right">
                                            @foreach ($game['platforms'] ?? [] as $platform)
                                                <span>{{ $platform['platform']['name'] }}{{ !$loop->last ? ', ' : '' }}</span>
                                            @endforeach
                                        </dd>
                                    </div>
                                    @if ($game['playtime'] ?? false)
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Avg. Playtime</dt>
                                            <dd class="text-gray-900">{{ $game['playtime'] }} hours</dd>
                                        </div>
                                    @endif
                                    @if ($game['metacritic'] ?? false)
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Metacritic</dt>
                                            <dd class="text-gray-900">{{ $game['metacritic'] }}</dd>
                                        </div>
                                    @endif
                                    @if ($game['developers'] ?? false)
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Developer</dt>
                                            <dd class="text-gray-900 text-right">
                                                @foreach ($game['developers'] as $dev)
                                                    <span>{{ $dev['name'] }}{{ !$loop->last ? ', ' : '' }}</span>
                                                @endforeach
                                            </dd>
                                        </div>
                                    @endif
                                </dl>
                            </div>

                            @if (!empty($screenshots))
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="font-semibold text-gray-900 mb-3">Screenshots</h3>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach (array_slice($screenshots, 0, 4) as $screenshot)
                                            <img src="{{ $screenshot['image'] }}" alt="Screenshot"
                                                class="rounded-md w-full h-24 object-cover hover:opacity-90 cursor-pointer transition"
                                                onclick="window.open('{{ $screenshot['image'] }}', '_blank')">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Forum Discussions</h3>
                <a href="{{ route('forum.index', ['game_id' => $game['id']]) }}"
                    class="text-indigo-600 hover:text-indigo-800">View all discussions for {{ $game['name'] }} &rarr;</a>
            </div>
        </div>
    </div>
</x-app-layout>
