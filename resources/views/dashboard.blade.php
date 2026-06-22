<x-app-layout>
    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-900/40 to-gray-900 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-10 mb-8 border-b border-[#2a2a2a]">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-2xl font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-2xl font-bold">{{ auth()->user()->name }}</h1>
                <p class="text-gray-400 text-sm mt-0.5">{{ auth()->user()->email }}</p>
                <span class="text-xs px-2 py-0.5 rounded mt-1 inline-block
                    {{ auth()->user()->role === 'admin' ? 'bg-red-900/50 text-red-400 border border-red-800' : 'bg-blue-900/50 text-blue-400 border border-blue-800' }}">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-px bg-[#2a2a2a] rounded-lg overflow-hidden mb-8">
        <div class="bg-gray-900 p-5">
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Total Wishlist</p>
            <p class="text-3xl font-bold text-white">{{ auth()->user()->wishlistItems()->count() }}</p>
        </div>
        <div class="bg-gray-900 p-5">
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Sudah Dimiliki</p>
            <p class="text-3xl font-bold text-green-400">{{ auth()->user()->wishlistItems()->where('status', 'owned')->count() }}</p>
        </div>
        <div class="bg-gray-900 p-5">
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Ingin Dibeli</p>
            <p class="text-3xl font-bold text-yellow-400">{{ auth()->user()->wishlistItems()->where('status', 'want_to_buy')->count() }}</p>
        </div>
        <div class="bg-gray-900 p-5">
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Sedang Dimainkan</p>
            <p class="text-3xl font-bold text-blue-400">{{ auth()->user()->wishlistItems()->where('status', 'playing')->count() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Wishlist Terbaru --}}
        <div class="lg:col-span-2">
            <div class="flex items-center gap-2 mb-4">
                <span class="inline-block w-[14px] h-[1px] bg-[#e21c1c]"></span>
                <h2 class="font-semibold text-gray-200">Wishlist Terbaru</h2>
                <a href="{{ route('wishlist.index') }}" class="ml-auto text-blue-400 hover:text-blue-300 text-xs transition">Lihat semua</a>
            </div>
            @php $recentWishlist = auth()->user()->wishlistItems()->latest()->take(5)->get(); @endphp
            @if($recentWishlist->isEmpty())
                <div class="bg-gray-900 border border-[#2a2a2a] rounded-lg p-8 text-center text-gray-700 text-sm">
                    Belum ada game di wishlist.
                </div>
            @else
                <div class="bg-gray-900 border border-[#2a2a2a] rounded-lg divide-y divide-[#2a2a2a]">
                    @foreach($recentWishlist as $item)
                        <div class="flex items-center gap-4 p-4">
                            <img src="{{ $item->game_image ?? 'https://via.placeholder.com/60x34?text=N/A' }}"
                                alt="{{ $item->game_title }}"
                                class="w-16 h-9 object-cover rounded shrink-0">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('games.show', $item->rawg_game_id) }}"
                                    class="text-sm font-medium hover:text-blue-400 transition truncate block">{{ $item->game_title }}</a>
                            </div>
                            <span class="text-xs px-2 py-0.5 rounded shrink-0
                                {{ $item->status === 'owned' ? 'bg-green-900/50 text-green-400' :
                                   ($item->status === 'playing' ? 'bg-blue-900/50 text-blue-400' :
                                   'bg-yellow-900/50 text-yellow-400') }}">
                                {{ $item->status === 'owned' ? 'Owned' : ($item->status === 'playing' ? 'Playing' : 'Want to Buy') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        @if(auth()->user()->role === 'admin')
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <span class="inline-block w-[14px] h-[1px] bg-[#e21c1c]"></span>
                    <h2 class="font-semibold text-gray-200">Menu</h2>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center justify-between bg-red-900/20 border border-[#2a2a2a] hover:border-red-500 rounded-lg px-4 py-3 transition group">
                        <span class="text-sm font-medium text-red-400 group-hover:text-red-300 transition">Admin Panel</span>
                        <span class="text-red-800 group-hover:text-red-400 transition">›</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>