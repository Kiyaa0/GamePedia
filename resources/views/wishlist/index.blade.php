<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Wishlist</h2>
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

            @if ($items->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        <p class="text-lg mb-4">Your wishlist is empty.</p>
                        <a href="{{ route('games.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Browse Games
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($items as $item)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            @if ($item->game_image)
                                <img src="{{ $item->game_image }}" alt="{{ $item->game_title }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                                    No Image
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $item->game_title }}</h3>

                                <div class="mt-2 mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $item->status === 'owned' ? 'bg-green-100 text-green-800' : ($item->status === 'playing' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ str_replace('_', ' ', ucfirst($item->status)) }}
                                    </span>
                                </div>

                                @if ($item->notes)
                                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($item->notes, 80) }}</p>
                                @endif

                                <div class="flex gap-2 mt-auto">
                                    <form action="{{ route('wishlist.update', $item) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="want_to_buy" {{ $item->status === 'want_to_buy' ? 'selected' : '' }}>Want to Buy</option>
                                            <option value="owned" {{ $item->status === 'owned' ? 'selected' : '' }}>Owned</option>
                                            <option value="playing" {{ $item->status === 'playing' ? 'selected' : '' }}>Playing</option>
                                        </select>
                                    </form>

                                    <form action="{{ route('wishlist.destroy', $item) }}" method="POST"
                                        onsubmit="return confirm('Remove from wishlist?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-2 bg-red-100 text-red-600 text-xs rounded-md hover:bg-red-200 transition">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
