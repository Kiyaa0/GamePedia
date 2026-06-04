<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('forum.index') }}" class="text-gray-400 hover:text-white text-sm transition">Kembali</a>
        </div>

        <h1 class="text-2xl font-bold mb-6">Buat Diskusi Baru</h1>

        <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
            <form action="{{ route('forum.store') }}" method="POST">
                @csrf

                @if($game)
                    <input type="hidden" name="rawg_game_id" value="{{ $game['id'] }}">
                    <input type="hidden" name="game_title" value="{{ $game['name'] }}">
                    <div class="mb-4 px-4 py-3 bg-indigo-600/20 border border-indigo-600/40 rounded-md">
                        <p class="text-sm text-indigo-300">Diskusi untuk: <strong>{{ $game['name'] }}</strong></p>
                    </div>
                @else
                    <div class="mb-4">
                        <label class="text-xs text-gray-400 block mb-1">RAWG Game ID</label>
                        <input type="text" name="rawg_game_id" value="{{ old('rawg_game_id') }}"
                            class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500"
                            required placeholder="e.g. 3498">
                        <x-input-error :messages="$errors->get('rawg_game_id')" class="mt-1" />
                    </div>
                    <div class="mb-4">
                        <label class="text-xs text-gray-400 block mb-1">Nama Game</label>
                        <input type="text" name="game_title" value="{{ old('game_title') }}"
                            class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500"
                            required placeholder="Grand Theft Auto V">
                        <x-input-error :messages="$errors->get('game_title')" class="mt-1" />
                    </div>
                @endif

                <div class="mb-4">
                    <label class="text-xs text-gray-400 block mb-1">Judul Post</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500"
                        required placeholder="Apa yang ingin kamu diskusikan?">
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <div class="mb-6">
                    <label class="text-xs text-gray-400 block mb-1">Isi</label>
                    <textarea name="body" rows="8"
                        class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 resize-none"
                        required placeholder="Tulis isi diskusi kamu...">{{ old('body') }}</textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-1" />
                </div>

                <div class="flex items-center gap-3">
                    <button class="bg-indigo-600 hover:bg-indigo-700 px-5 py-2 rounded-md text-sm font-medium transition">Buat Post</button>
                    <a href="{{ route('forum.index') }}" class="text-gray-400 hover:text-white text-sm transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>