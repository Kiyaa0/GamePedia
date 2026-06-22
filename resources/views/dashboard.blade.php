@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-8 py-10 text-white">

    {{-- 1. Welcome Section --}}
    <div class="mb-12">
        <h1 class="text-5xl font-bold uppercase">Dashboard</h1>
        <p class="text-gray-400 mt-2">
            Welcome back, <span class="text-red-600 font-bold">{{ Auth::user()->name }}</span>! Berikut adalah ringkasan akunmu.
        </p>
    </div>

    {{-- 2. Stats Overview --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-[#1a1a1a] border-l-4 border-red-600 rounded p-6">
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Total Wishlist</p>
            <p class="text-4xl font-bold">{{ auth()->user()->wishlistItems()->count() }}</p>
        </div>
        <div class="bg-[#1a1a1a] border-l-4 border-gray-800 rounded p-6">
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Reviews</p>
            <p class="text-4xl font-bold text-gray-300">0</p>
        </div>
        <div class="bg-[#1a1a1a] border-l-4 border-gray-800 rounded p-6">
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Forum Posts</p>
            <p class="text-4xl font-bold text-gray-300">{{ auth()->user()->forumPosts()->count() }}</p>
        </div>
        <div class="bg-[#1a1a1a] border-l-4 border-gray-800 rounded p-6">
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Completed</p>
            <p class="text-4xl font-bold text-gray-300">{{ auth()->user()->wishlistItems()->where('status', 'owned')->count() }}</p>
        </div>
    </div>

    {{-- 3. Main Layout (2 Kolom) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

        {{-- 4. Kolom Kiri - Recent Activity --}}
        <div class="md:col-span-2">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-6 h-[2px] bg-red-600"></div>
                <h3 class="text-lg font-bold uppercase tracking-widest">Recent Activity</h3>
            </div>

            @php $recentWishlist = auth()->user()->wishlistItems()->latest()->take(3)->get(); @endphp

            <div class="bg-[#1a1a1a] rounded divide-y divide-gray-800">
                @forelse($recentWishlist as $item)
                    <div class="flex items-center justify-between px-6 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-[#222] rounded flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold uppercase">Game Ditambahkan</p>
                                <p class="text-xs text-gray-500">{{ $item->game_title }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-600 shrink-0">{{ $item->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-gray-600 text-sm">Belum ada aktivitas.</div>
                @endforelse

                @if(auth()->user()->forumPosts()->exists())
                    @foreach(auth()->user()->forumPosts()->latest()->take(2)->get() as $post)
                        <div class="flex items-center justify-between px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-[#222] rounded flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold uppercase">Forum Post</p>
                                    <p class="text-xs text-gray-500">{{ $post->title }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-600 shrink-0">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- 5. Kolom Kanan - Profile Card --}}
        <div class="md:col-span-1">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-6 h-[2px] bg-red-600"></div>
                <h3 class="text-lg font-bold uppercase tracking-widest">Profile</h3>
            </div>

            <div class="bg-[#1a1a1a] border border-gray-800 rounded text-center p-8">
                <div class="w-20 h-20 mx-auto bg-red-800 border-4 border-gray-800 rounded-full flex items-center justify-center">
                    <span class="text-3xl font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <h4 class="text-white font-bold uppercase mt-4">{{ Auth::user()->name }}</h4>
                <p class="text-xs text-gray-500 tracking-widest mt-1">{{ Auth::user()->email }}</p>

                <div class="border-t border-gray-800 my-6"></div>

                <p class="text-[10px] text-gray-500 font-bold tracking-widest mb-3">FAVORITE GENRES</p>
                <div class="flex flex-wrap justify-center gap-2">
                    <span class="text-[10px] text-gray-400 border border-gray-700 px-3 py-1 rounded-sm uppercase tracking-wider">Action</span>
                    <span class="text-[10px] text-gray-400 border border-gray-700 px-3 py-1 rounded-sm uppercase tracking-wider">RPG</span>
                    <span class="text-[10px] text-gray-400 border border-gray-700 px-3 py-1 rounded-sm uppercase tracking-wider">Adventure</span>
                </div>
            </div>

            <div class="mt-4 space-y-3">
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="block w-full bg-white text-black font-bold text-center px-6 py-3 rounded hover:bg-gray-200 transition">
                        ADMIN MANAGEMENT
                    </a>
                @endif
                <a href="{{ route('profile.edit') }}"
                    class="block w-full border border-gray-700 text-gray-400 font-bold text-center px-6 py-3 rounded hover:bg-[#1a1a1a] transition">
                    EDIT PROFILE
                </a>
            </div>
        </div>

    </div>
</div>
@endsection