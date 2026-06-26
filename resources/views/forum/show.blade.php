@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 md:px-0">
        <div class="mb-4">
            <a href="{{ route('forum.index') }}" class="text-gray-400 hover:text-white text-sm transition">&larr; Kembali ke Forum</a>
        </div>

        {{-- Post Utama --}}
        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-4 md:p-6 mb-6">
            <div class="flex items-start md:items-center justify-between mb-4 gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-[#E51920] rounded-full flex items-center justify-center font-semibold text-xs md:text-sm shrink-0">
                        {{ strtoupper(substr($forumPost->user->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-medium text-xs md:text-sm">{{ $forumPost->user->name }}</p>
                        <p class="text-[10px] md:text-xs text-gray-500">{{ $forumPost->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex gap-2 shrink-0">
                    @can('update', $forumPost)
                        <a href="{{ route('forum.edit', $forumPost) }}"
                            class="px-2 md:px-3 py-1 bg-[#222] hover:bg-[#333] text-xs md:text-sm rounded-md transition">Edit</a>
                    @endcan
                    @can('delete', $forumPost)
                        <form action="{{ route('forum.destroy', $forumPost) }}" method="POST"
                            onsubmit="return confirm('Hapus post ini?')">
                            @csrf @method('DELETE')
                            <button class="px-2 md:px-3 py-1 bg-[#E51920]/20 hover:bg-[#E51920]/40 text-[#E51920] text-xs md:text-sm rounded-md transition">Hapus</button>
                        </form>
                    @endcan
                </div>
            </div>

            <h1 class="text-base md:text-xl font-bold mb-2">{{ $forumPost->title }}</h1>
            <p class="text-[10px] md:text-xs text-gray-500 mb-4">
                Game: <a href="{{ route('games.show', $forumPost->rawg_game_id) }}" class="text-[#E51920] hover:text-red-400">{{ $forumPost->game_title }}</a>
            </p>
            <p class="text-gray-300 text-xs md:text-sm leading-relaxed">{{ $forumPost->body }}</p>
        </div>

        {{-- Replies --}}
        <div class="flex items-center gap-2 mb-4">
            <span class="inline-block w-[14px] h-[1px] bg-[#E51920]"></span>
            <h3 class="font-semibold text-xs md:text-sm text-gray-300">Balasan ({{ $forumPost->replies->count() }})</h3>
        </div>

        @if($forumPost->replies->isEmpty())
            <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-4 md:p-6 text-center text-gray-500 text-sm mb-6">
                Belum ada balasan.
            </div>
        @else
            <div class="space-y-3 mb-6">
                @foreach($forumPost->replies as $reply)
                    <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-3 md:p-4">
                        <div class="flex items-start md:items-center justify-between mb-2 gap-2">
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="w-7 h-7 md:w-8 md:h-8 bg-[#222] rounded-full flex items-center justify-center text-[10px] md:text-xs font-semibold shrink-0">
                                    {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs md:text-sm font-medium truncate">{{ $reply->user->name }}</p>
                                    <p class="text-[10px] md:text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex gap-1 md:gap-2 shrink-0">
                                @can('update', $reply)
                                    <a href="{{ route('replies.edit', $reply) }}"
                                        class="px-1.5 md:px-2 py-1 bg-[#222] hover:bg-[#333] text-[10px] md:text-xs rounded transition">Edit</a>
                                @endcan
                                @can('delete', $reply)
                                    <form action="{{ route('replies.destroy', $reply) }}" method="POST"
                                        onsubmit="return confirm('Hapus balasan?')">
                                        @csrf @method('DELETE')
                                        <button class="px-1.5 md:px-2 py-1 bg-[#E51920]/20 hover:bg-[#E51920]/40 text-[#E51920] text-[10px] md:text-xs rounded transition">Hapus</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <p class="text-xs md:text-sm text-gray-300">{{ $reply->body }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Form Reply --}}
        @auth
            <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-4 md:p-5">
                <div class="flex items-center gap-2 mb-3">
                    <span class="inline-block w-[14px] h-[1px] bg-[#E51920]"></span>
                    <h4 class="font-medium text-xs md:text-sm">Tulis Balasan</h4>
                </div>
                <form action="{{ route('replies.store', $forumPost) }}" method="POST">
                    @csrf
                    <textarea name="body" rows="4" placeholder="Tulis balasan kamu..."
                        class="w-full bg-[#1a1a1a] border border-white/5 rounded-md px-3 md:px-4 py-2 text-xs md:text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#E51920] resize-none mb-3" required></textarea>
                    <x-input-error :messages="$errors->get('body')" class="mb-2" />
                    <button class="bg-[#E51920] hover:bg-red-600 px-4 md:px-5 py-2 rounded-md text-xs md:text-sm font-medium transition">Kirim Balasan</button>
                </form>
            </div>
        @endauth
    </div>
@endsection
