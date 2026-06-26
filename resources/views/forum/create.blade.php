@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 md:px-0">
        <div class="mb-4">
            <a href="{{ route('forum.index') }}" class="text-gray-400 hover:text-white text-sm transition">&larr; Kembali</a>
        </div>

        <h1 class="text-xl md:text-2xl font-bold mb-6">Buat Diskusi Baru</h1>

        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-4 md:p-6">
            <form action="{{ route('forum.store') }}" method="POST">
                @csrf

                @php
                    $initialGame = $game;
                    if (! $initialGame && old('rawg_game_id')) {
                        $initialGame = ['id' => old('rawg_game_id'), 'name' => old('game_title'), 'released' => null];
                    }
                @endphp

                <div x-data="gameSearch({{ json_encode($initialGame) }})">
                    <input type="hidden" name="rawg_game_id" x-bind:value="selectedGameId">
                    <input type="hidden" name="game_title" x-bind:value="selectedGameTitle">

                    <template x-if="selectedGame">
                        <div class="mb-4 px-4 py-3 bg-[#E51920]/10 border border-[#E51920]/30 rounded-md flex items-center justify-between">
                            <p class="text-sm text-[#E51920]">Diskusi untuk: <strong x-text="selectedGame.name"></strong></p>
                            <button @click="clear()" type="button" class="text-[#E51920] hover:text-red-400 text-xs transition">Ganti Game</button>
                        </div>
                    </template>

                    <template x-if="!selectedGame">
                        <div class="mb-4 relative">
                            <label class="text-xs text-gray-400 block mb-1">Cari Game</label>
                            <input type="text" x-model="query" @input.debounce.350ms="search"
                                @click.outside="open = false"
                                @keydown.escape="open = false"
                                placeholder="Ketik nama game..."
                                class="w-full bg-[#1a1a1a] border border-white/5 rounded-md px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#E51920]"
                                :class="{ 'rounded-b-none': open && results.length }">

                            <div x-show="loading" class="absolute right-3 top-8">
                                <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </div>

                            <div x-show="open && results.length"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="absolute z-20 w-full bg-[#1a1a1a] border border-t-0 border-white/5 rounded-b-md max-h-48 overflow-y-auto">
                                <template x-for="game in results" :key="game.id">
                                    <div @click="select(game)" @keydown.enter="select(game)"
                                        class="px-4 py-2.5 text-sm text-gray-300 hover:bg-[#222] hover:text-white cursor-pointer border-b border-white/5 last:border-b-0 flex items-center justify-between">
                                        <span x-text="game.name"></span>
                                        <span class="text-gray-500 text-xs" x-text="game.released ? game.released.substring(0, 4) : ''"></span>
                                    </div>
                                </template>
                            </div>

                            <div x-show="open && !loading && results.length === 0 && query.length >= 2"
                                class="absolute z-20 w-full bg-[#1a1a1a] border border-t-0 border-white/5 rounded-b-md px-4 py-3 text-sm text-gray-500">
                                Tidak ada game ditemukan
                            </div>

                            <x-input-error :messages="$errors->get('rawg_game_id')" class="mt-1" />
                        </div>
                    </template>
                </div>

                <div class="mb-4">
                    <label class="text-xs text-gray-400 block mb-1">Judul Post</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full bg-[#1a1a1a] border border-white/5 rounded-md px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#E51920]"
                        required placeholder="Apa yang ingin kamu diskusikan?">
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <div class="mb-6">
                    <label class="text-xs text-gray-400 block mb-1">Isi</label>
                    <textarea name="body" rows="8"
                        class="w-full bg-[#1a1a1a] border border-white/5 rounded-md px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#E51920] resize-none"
                        required placeholder="Tulis isi diskusi kamu...">{{ old('body') }}</textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-1" />
                </div>

                <div class="flex items-center gap-3">
                    <button class="bg-[#E51920] hover:bg-red-600 px-5 py-2 rounded-md text-sm font-medium transition">Buat Post</button>
                    <a href="{{ route('forum.index') }}" class="text-gray-400 hover:text-white text-sm transition">Batal</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('gameSearch', (initialGame) => ({
                    query: '',
                    results: [],
                    selectedGame: initialGame && initialGame.id ? initialGame : null,
                    selectedGameId: initialGame && initialGame.id ? String(initialGame.id) : '',
                    selectedGameTitle: initialGame && initialGame.name ? initialGame.name : '',
                    open: false,
                    loading: false,

                    async search() {
                        if (this.query.length < 2) {
                            this.results = [];
                            this.open = false;
                            return;
                        }

                        this.loading = true;
                        this.open = true;

                        try {
                            const response = await fetch('/games/search?q=' + encodeURIComponent(this.query));
                            if (!response.ok) throw new Error('Network error');
                            this.results = await response.json();
                        } catch (e) {
                            this.results = [];
                        } finally {
                            this.loading = false;
                        }
                    },

                    select(game) {
                        this.selectedGame = game;
                        this.selectedGameId = String(game.id);
                        this.selectedGameTitle = game.name;
                        this.open = false;
                        this.query = '';
                    },

                    clear() {
                        this.selectedGame = null;
                        this.selectedGameId = '';
                        this.selectedGameTitle = '';
                        this.query = '';
                        this.results = [];
                    },
                }));
            });
        </script>
    @endpush
@endsection
