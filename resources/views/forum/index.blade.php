@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
            <span class="inline-block w-[14px] h-[1px] bg-[#E51920]"></span>
            <h1 class="text-2xl font-bold">Forum Diskusi</h1>
        </div>
        <a href="{{ route('forum.create') }}"
            class="bg-[#E51920] hover:bg-red-600 px-4 py-2 rounded-md text-sm font-medium transition">
            Post Baru
        </a>
    </div>

    <div class="mb-6">
        <form action="{{ route('forum.index') }}" method="GET" class="flex gap-2">
            @if(request('game_id')) <input type="hidden" name="game_id" value="{{ request('game_id') }}"> @endif
            <input type="text" name="search" placeholder="Cari diskusi..." value="{{ request('search') }}"
                class="bg-[#1a1a1a] border border-white/5 rounded-md px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#E51920] w-64">
            <button class="bg-[#E51920] hover:bg-red-600 px-4 py-2 rounded-md text-sm transition">Cari</button>
            @if(request()->anyFilled(['search', 'game_id']))
                <a href="{{ route('forum.index') }}" class="bg-[#222] hover:bg-[#333] px-4 py-2 rounded-md text-sm transition">Reset</a>
            @endif
        </form>
    </div>

    @if($posts->isEmpty())
        <div class="text-center py-20 text-gray-500">Belum ada diskusi.</div>
    @else
        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg divide-y divide-white/5">
            @foreach($posts as $post)
                <div class="p-5 hover:bg-white/[0.02] transition flex items-start justify-between gap-4">
                    <div class="min-w-0 flex-1">
                        <a href="{{ route('forum.show', $post) }}" class="font-semibold hover:text-[#E51920] transition">{{ $post->title }}</a>
                        <div class="flex flex-wrap items-center gap-3 mt-1 text-xs text-gray-500">
                            <span>{{ $post->user->name }}</span>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                            <a href="{{ route('games.show', $post->rawg_game_id) }}" class="text-[#E51920] hover:text-red-400">{{ $post->game_title }}</a>
                            <span>{{ $post->replies_count }} {{ Str::plural('balasan', $post->replies_count) }}</span>
                        </div>
                        <p class="text-sm text-gray-400 mt-2">{{ Str::limit($post->body, 200) }}</p>
                    </div>
                    @can('delete', $post)
                        <form action="{{ route('forum.destroy', $post) }}" method="POST"
                            onsubmit="return confirm('Hapus post ini?')" class="shrink-0">
                            @csrf @method('DELETE')
                            <button class="px-2 py-1 bg-[#E51920]/20 hover:bg-[#E51920]/40 text-[#E51920] text-xs rounded transition">Hapus</button>
                        </form>
                    @endcan
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $posts->links() }}</div>
    @endif
@endsection
