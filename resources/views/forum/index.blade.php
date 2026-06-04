<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Forum Diskusi</h1>
        <a href="{{ route('forum.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md text-sm font-medium transition">
            Post Baru
        </a>
    </div>

    <div class="mb-6">
        <form action="{{ route('forum.index') }}" method="GET" class="flex gap-2">
            @if(request('game_id')) <input type="hidden" name="game_id" value="{{ request('game_id') }}"> @endif
            <input type="text" name="search" placeholder="Cari diskusi..." value="{{ request('search') }}"
                class="bg-gray-800 border border-gray-700 rounded-md px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 w-64">
            <button class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md text-sm transition">Cari</button>
            @if(request()->anyFilled(['search', 'game_id']))
                <a href="{{ route('forum.index') }}" class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded-md text-sm transition">Reset</a>
            @endif
        </form>
    </div>

    @if($posts->isEmpty())
        <div class="text-center py-20 text-gray-500">Belum ada diskusi.</div>
    @else
        <div class="bg-gray-900 border border-gray-800 rounded-lg divide-y divide-gray-800">
            @foreach($posts as $post)
                <div class="p-5 hover:bg-gray-800/50 transition">
                    <a href="{{ route('forum.show', $post) }}" class="font-semibold hover:text-indigo-400 transition">{{ $post->title }}</a>
                    <div class="flex flex-wrap items-center gap-3 mt-1 text-xs text-gray-500">
                        <span>{{ $post->user->name }}</span>
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                        <a href="{{ route('games.show', $post->rawg_game_id) }}" class="text-indigo-400 hover:text-indigo-300">{{ $post->game_title }}</a>
                        <span>{{ $post->replies_count }} {{ Str::plural('balasan', $post->replies_count) }}</span>
                    </div>
                    <p class="text-sm text-gray-400 mt-2">{{ Str::limit($post->body, 200) }}</p>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $posts->links() }}</div>
    @endif
</x-app-layout>