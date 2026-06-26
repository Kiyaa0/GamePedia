@php
    $user = Auth::user();
@endphp

@extends('layouts.app')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-3">
        <h1 class="text-xl md:text-2xl font-bold">Manajemen User</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-xs md:text-sm text-gray-400 hover:text-white transition">&larr; Kembali ke Admin Panel</a>
    </div>

    {{-- Search --}}
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row gap-2 md:gap-3">
            <input type="text" name="search" placeholder="Cari nama atau email..."
                value="{{ request('search') }}"
                class="w-full bg-[#1a1a1a] border border-white/5 rounded-lg px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-600 transition">
            <div class="flex gap-2">
                <button type="submit" class="flex-1 sm:flex-none bg-[#E51920] text-white px-4 md:px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-red-600 transition">Cari</button>
                @if (request('search'))
                    <a href="{{ route('admin.users.index') }}" class="bg-[#1a1a1a] text-gray-400 px-4 md:px-5 py-2.5 rounded-lg text-sm font-bold hover:text-white transition border border-white/5">Reset</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-[#1a1a1a] border border-white/5 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs md:text-sm">
                <thead>
                    <tr class="bg-[#222] text-gray-400 uppercase tracking-widest text-[10px] md:text-xs">
                        <th class="text-left px-3 md:px-5 py-3 md:py-4 w-8 md:w-12">#</th>
                        <th class="text-left px-3 md:px-5 py-3 md:py-4">Nama</th>
                        <th class="text-left px-3 md:px-5 py-3 md:py-4 hidden md:table-cell">Email</th>
                        <th class="text-left px-3 md:px-5 py-3 md:py-4">Role</th>
                        <th class="text-left px-3 md:px-5 py-3 md:py-4 hidden md:table-cell">Tanggal Daftar</th>
                        <th class="text-left px-3 md:px-5 py-3 md:py-4 hidden sm:table-cell">Status</th>
                        <th class="text-right px-3 md:px-5 py-3 md:py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($users as $u)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="px-3 md:px-5 py-3 md:py-4 text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-3 md:px-5 py-3 md:py-4">
                                <div class="flex items-center gap-2 md:gap-3">
                                    <div class="w-7 h-7 md:w-8 md:h-8 bg-[#222] rounded-full flex items-center justify-center text-[10px] md:text-xs font-bold text-white shrink-0">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-white text-xs md:text-sm truncate max-w-[80px] md:max-w-none">{{ $u->name }}</span>
                                </div>
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4 text-gray-400 hidden md:table-cell text-xs">{{ $u->email }}</td>
                            <td class="px-3 md:px-5 py-3 md:py-4">
                                @if ($u->role === 'admin')
                                    <span class="text-[10px] md:text-xs px-1.5 md:px-2.5 py-0.5 md:py-1 rounded-full bg-purple-900/50 text-purple-400 font-medium">Admin</span>
                                @else
                                    <span class="text-[10px] md:text-xs px-1.5 md:px-2.5 py-0.5 md:py-1 rounded-full bg-gray-800 text-gray-400 font-medium">User</span>
                                @endif
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4 text-gray-500 text-[10px] md:text-xs hidden md:table-cell">{{ $u->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-3 md:px-5 py-3 md:py-4 hidden sm:table-cell">
                                @if ($u->suspended_at)
                                    <span class="text-[10px] md:text-xs px-1.5 md:px-2.5 py-0.5 md:py-1 rounded-full bg-red-900/50 text-red-400 font-medium">Suspend</span>
                                @else
                                    <span class="text-[10px] md:text-xs px-1.5 md:px-2.5 py-0.5 md:py-1 rounded-full bg-green-900/50 text-green-400 font-medium">Aktif</span>
                                @endif
                            </td>
                            <td class="px-3 md:px-5 py-3 md:py-4">
                                <div class="flex items-center justify-end gap-1 md:gap-2 flex-wrap">
                                    {{-- Role Toggle --}}
                                    <form action="{{ route('admin.users.update-role', $u) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            onclick="return confirm('Ubah role {{ $u->name }} menjadi {{ $u->role === 'admin' ? 'User' : 'Admin' }}?')"
                                            class="text-[10px] md:text-xs px-1.5 md:px-3 py-1 md:py-1.5 rounded font-medium transition whitespace-nowrap
                                                {{ $u->role === 'admin'
                                                    ? 'bg-gray-800 text-gray-400 hover:bg-gray-700'
                                                    : 'bg-purple-900/30 text-purple-400 hover:bg-purple-900/50' }}">
                                            {{ $u->role === 'admin' ? 'User' : 'Admin' }}
                                        </button>
                                    </form>

                                    {{-- Suspend / Unsuspend --}}
                                    @if ($u->suspended_at)
                                        <form action="{{ route('admin.users.unsuspend', $u) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-[10px] md:text-xs px-1.5 md:px-3 py-1 md:py-1.5 rounded font-medium bg-green-900/30 text-green-400 hover:bg-green-900/50 transition whitespace-nowrap">
                                                Aktif
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.suspend', $u) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                onclick="return confirm('Suspend akun {{ $u->name }}?')"
                                                class="text-[10px] md:text-xs px-1.5 md:px-3 py-1 md:py-1.5 rounded font-medium bg-yellow-900/30 text-yellow-400 hover:bg-yellow-900/50 transition whitespace-nowrap">
                                                Suspend
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Hapus akun {{ $u->name }}? Data terkait akan ikut terhapus.')"
                                            class="text-[10px] md:text-xs px-1.5 md:px-3 py-1 md:py-1.5 rounded font-medium bg-red-900/30 text-red-400 hover:bg-red-900/50 transition whitespace-nowrap">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-3 md:px-5 py-8 md:py-10 text-center text-gray-600 text-sm">
                                Tidak ada user ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $users->links() }}
    </div>
@endsection
