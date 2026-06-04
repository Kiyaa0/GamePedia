<x-app-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('forum.index') }}" class="text-gray-400 hover:text-white text-sm transition">Kembali ke Forum</a>
        </div>

        {{-- Post Utama --}}
        <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center font-semibold text-sm">
                        {{ strtoupper(substr($forumPost->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ $forumPost->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $forumPost->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @can('update', $forumPost)
                    <div class="flex gap-2">
                        <a href="{{ route('forum.edit', $forumPost) }}"
                            class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-sm rounded-md transition">Edit</a>
                        <form action="{{ route('forum.destroy', $forumPost) }}" method="POST"
                            onsubmit="return confirm('Hapus post ini?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-900/50 hover:bg-red-900 text-red-400 text-sm rounded-md transition">Hapus</button>
                        </form>
                    </div>
                @endcan
            </div>

            <h1 class="text-xl font-bold mb-2">{{ $forumPost->title }}</h1>
            <p class="text-xs text-gray-500 mb-4">
                Game: <a href="{{ route('games.show', $forumPost->rawg_game_id) }}" class="text-indigo-400 hover:text-indigo-300">{{ $forumPost->game_title }}</a>
            </p>
            <p class="text-gray-300 text-sm leading-relaxed">{{ $forumPost->body }}</p>
        </div>

        {{-- Replies --}}
        <h3 class="font-semibold mb-4 text-sm text-gray-300">Balasan ({{ $forumPost->replies->count() }})</h3>

        @if($forumPost->replies->isEmpty())
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 text-center text-gray-500 text-sm mb-6">
                Belum ada balasan.
            </div>
        @else
            <div class="space-y-3 mb-6">
                @foreach($forumPost->replies as $reply)
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-xs font-semibold">
                                    {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ $reply->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @can('update', $reply)
                                <div class="flex gap-2">
                                    <a href="{{ route('replies.edit', $reply) }}"
                                        class="px-2 py-1 bg-gray-700 hover:bg-gray-600 text-xs rounded transition">Edit</a>
                                    <form action="{{ route('replies.destroy', $reply) }}" method="POST"
                                        onsubmit="return confirm('Hapus balasan?')">
                                        @csrf @method('DELETE')
                                        <button class="px-2 py-1 bg-red-900/50 hover:bg-red-900 text-red-400 text-xs rounded transition">Hapus</button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                        <p class="text-sm text-gray-300">{{ $reply->body }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Form Reply --}}
        @auth
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                <h4 class="font-medium text-sm mb-3">Tulis Balasan</h4>
                <form action="{{ route('replies.store', $forumPost) }}" method="POST">
                    @csrf
                    <textarea name="body" rows="4" placeholder="Tulis balasan kamu..."
                        class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 resize-none mb-3" required></textarea>
                    <x-input-error :messages="$errors->get('body')" class="mb-2" />
                    <button class="bg-indigo-600 hover:bg-indigo-700 px-5 py-2 rounded-md text-sm font-medium transition">Kirim Balasan</button>
                </form>
            </div>
        @endauth
    </div>
</x-app-layout>