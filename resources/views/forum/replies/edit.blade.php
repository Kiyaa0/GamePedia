@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 md:px-0">
        <div class="mb-4">
            <a href="{{ route('forum.show', $forumReply->forumPost) }}" class="text-gray-400 hover:text-white text-sm transition">&larr; Kembali</a>
        </div>

        <h1 class="text-xl md:text-2xl font-bold mb-6">Edit Balasan</h1>

        <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-4 md:p-6">
            <form action="{{ route('replies.update', $forumReply) }}" method="POST">
                @csrf @method('PATCH')

                <div class="mb-6">
                    <label class="text-xs text-gray-400 block mb-1">Balasan</label>
                    <textarea name="body" rows="6"
                        class="w-full bg-[#1a1a1a] border border-white/5 rounded-md px-4 py-2 text-sm text-white focus:outline-none focus:border-[#E51920] resize-none"
                        required>{{ old('body', $forumReply->body) }}</textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-1" />
                </div>

                <div class="flex items-center gap-3">
                    <button class="bg-[#E51920] hover:bg-red-600 px-5 py-2 rounded-md text-sm font-medium transition">Simpan</button>
                    <a href="{{ route('forum.show', $forumReply->forumPost) }}" class="text-gray-400 hover:text-white text-sm transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
