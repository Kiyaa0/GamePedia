<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('forum.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">&larr; Back to Forum</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-1">{{ $forumPost->title }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-semibold">
                                {{ strtoupper(substr($forumPost->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $forumPost->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $forumPost->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @can('update', $forumPost)
                            <div class="flex gap-2">
                                <a href="{{ route('forum.edit', $forumPost) }}"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 text-sm rounded-md hover:bg-gray-200 transition">
                                    Edit
                                </a>
                                <form action="{{ route('forum.destroy', $forumPost) }}" method="POST"
                                    onsubmit="return confirm('Delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-100 text-red-600 text-sm rounded-md hover:bg-red-200 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>

                    <div class="mb-3">
                        <span class="text-sm text-gray-500">Game: <a href="{{ route('games.show', $forumPost->rawg_game_id) }}" class="text-indigo-600 hover:text-indigo-800">{{ $forumPost->game_title }}</a></span>
                    </div>

                    <div class="prose max-w-none text-gray-800">
                        {{ $forumPost->body }}
                    </div>
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Replies ({{ $forumPost->replies->count() }})
            </h3>

            @if ($forumPost->replies->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-center text-gray-500">
                        No replies yet. Be the first to reply!
                    </div>
                </div>
            @else
                <div class="space-y-4 mb-6">
                    @foreach ($forumPost->replies as $reply)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 font-semibold text-sm">
                                            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-sm text-gray-900">{{ $reply->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    @can('update', $reply)
                                        <div class="flex gap-2">
                                            <a href="{{ route('replies.edit', $reply) }}"
                                                class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded hover:bg-gray-200 transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('replies.destroy', $reply) }}" method="POST"
                                                onsubmit="return confirm('Delete this reply?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-2 py-1 bg-red-100 text-red-600 text-xs rounded hover:bg-red-200 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                                <div class="text-gray-700 text-sm">
                                    {{ $reply->body }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="font-medium text-gray-900 mb-4">Write a Reply</h4>
                    <form action="{{ route('replies.store', $forumPost) }}" method="POST">
                        @csrf
                        <textarea name="body" rows="4"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required placeholder="Share your thoughts..."></textarea>
                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                        <div class="mt-4">
                            <x-primary-button>Post Reply</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
