<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('forum.show', $forumReply->forumPost) }}" class="text-gray-400 hover:text-white text-sm transition">Kembali</a>
        </div>

        <h1 class="text-2xl font-bold mb-6">Edit Balasan</h1>

        <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
            <form action="{{ route('replies.update', $forumReply) }}" method="POST">
                @csrf @method('PATCH')

                <div class="mb-6">
                    <label class="text-xs text-gray-400 block mb-1">Balasan</label>
                    <textarea name="body" rows="6"
                        class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2 text-sm text-white focus:outline-none focus:border-indigo-500 resize-none"
                        required>{{ old('body', $forumReply->body) }}</textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-1" />
                </div>

                <div class="flex items-center gap-3">
                    <button class="bg-indigo-600 hover:bg-indigo-700 px-5 py-2 rounded-md text-sm font-medium transition">Simpan</button>
                    <a href="{{ route('forum.show', $forumReply->forumPost) }}" class="text-gray-400 hover:text-white text-sm transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>