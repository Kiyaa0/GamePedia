@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('forum.index') }}" class="text-gray-400 hover:text-white text-sm transition">Kembali ke Forum</a>
        </div>

        {{-- Post Utama --}}
        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#E51920] rounded-full flex items-center justify-center font-semibold text-sm">
                        {{ strtoupper(substr($forumPost->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ $forumPost->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $forumPost->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    @can('update', $forumPost)
                        <a href="{{ route('forum.edit', $forumPost) }}"
                            class="px-3 py-1 bg-[#222] hover:bg-[#333] text-sm rounded-md transition">Edit</a>
                    @endcan
                    @can('delete', $forumPost)
                        <form action="{{ route('forum.destroy', $forumPost) }}" method="POST"
                            onsubmit="return confirm('Hapus post ini?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-[#E51920]/20 hover:bg-[#E51920]/40 text-[#E51920] text-sm rounded-md transition">Hapus</button>
                        </form>
                    @endcan
                </div>
            </div>

            <h1 class="text-xl font-bold mb-2">{{ $forumPost->title }}</h1>
            <p class="text-xs text-gray-500 mb-4">
                Game: <a href="{{ route('games.show', $forumPost->rawg_game_id) }}" class="text-[#E51920] hover:text-red-400">{{ $forumPost->game_title }}</a>
            </p>
            <p class="text-gray-300 text-sm leading-relaxed">{{ $forumPost->body }}</p>
        </div>

        {{-- Replies --}}
        <div class="flex items-center gap-2 mb-4">
            <span class="inline-block w-[14px] h-[1px] bg-[#E51920]"></span>
            <h3 class="font-semibold text-sm text-gray-300">Balasan ({{ $forumPost->replies->count() }})</h3>
        </div>

        @if($forumPost->replies->isEmpty())
            <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-6 text-center text-gray-500 text-sm mb-6">
                Belum ada balasan.
            </div>
        @else
            <div class="space-y-3 mb-6">
                @foreach($forumPost->replies as $reply)
                    <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-[#222] rounded-full flex items-center justify-center text-xs font-semibold">
                                    {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ $reply->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                @can('update', $reply)
                                    <a href="{{ route('replies.edit', $reply) }}"
                                        class="px-2 py-1 bg-[#222] hover:bg-[#333] text-xs rounded transition">Edit</a>
                                @endcan
                                @can('delete', $reply)
                                    <form action="{{ route('replies.destroy', $reply) }}" method="POST"
                                        onsubmit="return confirm('Hapus balasan?')">
                                        @csrf @method('DELETE')
                                        <button class="px-2 py-1 bg-[#E51920]/20 hover:bg-[#E51920]/40 text-[#E51920] text-xs rounded transition">Hapus</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <p class="text-sm text-gray-300">{{ $reply->body }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Form Reply --}}
        @auth
            <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-5">
                <div class="flex items-center gap-2 mb-3">
                    <span class="inline-block w-[14px] h-[1px] bg-[#E51920]"></span>
                    <h4 class="font-medium text-sm">Tulis Balasan</h4>
                </div>
                <form action="{{ route('replies.store', $forumPost) }}" method="POST">
                    @csrf
                    <textarea name="body" rows="4" placeholder="Tulis balasan kamu..."
                        class="w-full bg-[#1a1a1a] border border-white/5 rounded-md px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#E51920] resize-none mb-3" required></textarea>
                    <x-input-error :messages="$errors->get('body')" class="mb-2" />
                    <button class="bg-[#E51920] hover:bg-red-600 px-5 py-2 rounded-md text-sm font-medium transition">Kirim Balasan</button>
                </form>
            </div>
        @endauth
    </div>
@endsection
