<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Game Encyclopedia</h2>
            <form action="{{ route('games.index') }}" method="GET" class="flex gap-2">
                @if (request('genre'))
                    <input type="hidden" name="genre" value="{{ request('genre') }}">
                @endif
                @if (request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <x-text-input
                    type="text"
                    name="search"
                    placeholder="Search games..."
                    :value="request('search')"
                    class="w-64"
                />
                <x-primary-button type="submit">Search</x-primary-button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span class="text-sm font-medium text-gray-700">Genres:</span>
                    <a href="{{ route('games.index', array_filter(['search' => $search, 'sort' => $sortBy !== '-rating' ? $sortBy : null])) }}"
                        class="px-3 py-1 text-xs rounded-full transition {{ !$genre ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        All
                    </a>
                    @foreach ($genres as $g)
                        <a href="{{ route('games.index', array_filter(['genre' => $g['slug'], 'search' => $search, 'sort' => $sortBy !== '-rating' ? $sortBy : null])) }}"
                            class="px-3 py-1 text-xs rounded-full transition {{ $genre === $g['slug'] ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $g['name'] }}
                        </a>
                    @endforeach
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-sm font-medium text-gray-700">Sort:</span>
                    @php
                        $sorts = [
                            '-rating' => 'Highest Rated',
                            '-released' => 'Newest',
                            '-added' => 'Most Added',
                            'name' => 'Name A-Z',
                        ];
                    @endphp
                    @foreach ($sorts as $key => $label)
                        <a href="{{ route('games.index', array_filter(['sort' => $key, 'search' => $search, 'genre' => $genre])) }}"
                            class="px-3 py-1 text-xs rounded-full transition {{ $sortBy === $key ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            @if (empty($games))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        @if ($search)
                            No games found for "{{ $search }}".
                        @else
                            Search for your favorite games above!
                        @endif
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($games as $game)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            <a href="{{ route('games.show', $game['id']) }}">
                                <img
                                    src="{{ $game['background_image'] ?? 'https://via.placeholder.com/300x200?text=No+Image' }}"
                                    alt="{{ $game['name'] }}"
                                    class="w-full h-48 object-cover"
                                    loading="lazy"
                                >
                            </a>
                            <div class="p-4">
                                <a href="{{ route('games.show', $game['id']) }}">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1 hover:text-indigo-600">{{ $game['name'] }}</h3>
                                </a>
                                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                                    <span>⭐ {{ $game['rating'] ?? 'N/A' }}</span>
                                    @if ($game['released'] ?? false)
                                        <span>• {{ \Carbon\Carbon::parse($game['released'])->format('Y') }}</span>
                                    @endif
                                </div>
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach (array_slice($game['genres'] ?? [], 0, 3) as $g)
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $g['name'] }}</span>
                                    @endforeach
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('games.show', $game['id']) }}"
                                        class="flex-1 text-center px-3 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700 transition">
                                        Details
                                    </a>
                                    <form action="{{ route('wishlist.add-from-game', $game['id']) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-2 bg-gray-100 text-gray-600 text-sm rounded-md hover:bg-gray-200 transition">
                                            + Wishlist
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($total > 20)
                    <div class="mt-6 flex justify-center gap-2">
                        @if ($currentPage > 1)
                            <a href="{{ route('games.index', array_filter(['search' => $search, 'genre' => $genre, 'sort' => $sortBy !== '-rating' ? $sortBy : null, 'page' => $currentPage - 1])) }}"
                                class="px-4 py-2 bg-white text-gray-700 rounded-md shadow hover:bg-gray-50 transition">
                                Previous
                            </a>
                        @endif
                        @if ($currentPage < ceil($total / 20))
                            <a href="{{ route('games.index', array_filter(['search' => $search, 'genre' => $genre, 'sort' => $sortBy !== '-rating' ? $sortBy : null, 'page' => $currentPage + 1])) }}"
                                class="px-4 py-2 bg-white text-gray-700 rounded-md shadow hover:bg-gray-50 transition">
                                Next
                            </a>
                        @endif
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
