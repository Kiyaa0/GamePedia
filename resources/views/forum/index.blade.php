<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Forum Discussions</h2>
            <a href="{{ route('forum.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                + New Post
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6">
                <form action="{{ route('forum.index') }}" method="GET" class="flex gap-2">
                    <x-text-input
                        type="text"
                        name="search"
                        placeholder="Search discussions..."
                        :value="request('search')"
                        class="w-64"
                    />
                    @if (request('game_id'))
                        <input type="hidden" name="game_id" value="{{ request('game_id') }}">
                    @endif
                    <x-primary-button type="submit">Search</x-primary-button>
                    @if (request()->anyFilled(['search', 'game_id']))
                        <a href="{{ route('forum.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            @if ($posts->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        No discussions yet. Start a new one!
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    @foreach ($posts as $post)
                        <div class="p-6 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <a href="{{ route('forum.show', $post) }}" class="text-lg font-semibold text-gray-900 hover:text-indigo-600">
                                        {{ $post->title }}
                                    </a>
                                    <div class="mt-1 flex items-center gap-4 text-sm text-gray-500">
                                        <span>By {{ $post->user->name }}</span>
                                        <span>• {{ $post->created_at->diffForHumans() }}</span>
                                        <span>• Game: {{ $post->game_title }}</span>
                                        <span>• {{ $post->replies_count }} {{ Str::plural('reply', $post->replies_count) }}</span>
                                    </div>
                                    <p class="mt-2 text-gray-600">{{ Str::limit($post->body, 200) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
