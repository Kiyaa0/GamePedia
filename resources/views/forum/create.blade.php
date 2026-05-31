<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Discussion</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('forum.store') }}" method="POST">
                        @csrf

                        @if ($game)
                            <input type="hidden" name="rawg_game_id" value="{{ $game['id'] }}">
                            <input type="hidden" name="game_title" value="{{ $game['name'] }}">
                            <div class="mb-4 p-3 bg-indigo-50 rounded-md">
                                <p class="text-sm text-indigo-700">
                                    Discussing: <strong>{{ $game['name'] }}</strong>
                                </p>
                            </div>
                        @else
                            <div class="mb-4">
                                <x-input-label for="rawg_game_id" value="RAWG Game ID" />
                                <x-text-input id="rawg_game_id" name="rawg_game_id" type="text" class="mt-1 block w-full"
                                    :value="old('rawg_game_id')" required placeholder="e.g. 3498" />
                                <x-input-error :messages="$errors->get('rawg_game_id')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="game_title" value="Game Title" />
                                <x-text-input id="game_title" name="game_title" type="text" class="mt-1 block w-full"
                                    :value="old('game_title')" required placeholder="Grand Theft Auto V" />
                                <x-input-error :messages="$errors->get('game_title')" class="mt-2" />
                            </div>
                        @endif

                        <div class="mb-4">
                            <x-input-label for="title" value="Post Title" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                :value="old('title')" required placeholder="What do you want to discuss?" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="body" value="Content" />
                            <textarea id="body" name="body" rows="8"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required placeholder="Write your thoughts...">{{ old('body') }}</textarea>
                            <x-input-error :messages="$errors->get('body')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Create Post</x-primary-button>
                            <a href="{{ route('forum.index') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
