@php
    $user = Auth::user();
@endphp

@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Manajemen User</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-400 hover:text-white transition">&larr; Kembali ke Admin Panel</a>
    </div>

    {{-- Search --}}
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-3">
            <input type="text" name="search" placeholder="Cari nama atau email..."
                value="{{ request('search') }}"
                class="flex-1 bg-[#1a1a1a] border border-white/5 rounded-lg px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-600 transition">
            <button type="submit" class="bg-[#E51920] text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-red-600 transition">Cari</button>
            @if (request('search'))
                <a href="{{ route('admin.users.index') }}" class="bg-[#1a1a1a] text-gray-400 px-5 py-2.5 rounded-lg text-sm font-bold hover:text-white transition border border-white/5">Reset</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-[#1a1a1a] border border-white/5 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-[#222] text-gray-400 uppercase tracking-widest text-xs">
                        <th class="text-left px-5 py-4 w-12">#</th>
                        <th class="text-left px-5 py-4">Nama</th>
                        <th class="text-left px-5 py-4">Email</th>
                        <th class="text-left px-5 py-4">Role</th>
                        <th class="text-left px-5 py-4">Tanggal Daftar</th>
                        <th class="text-left px-5 py-4">Status</th>
                        <th class="text-right px-5 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($users as $u)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="px-5 py-4 text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-[#222] rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-white">{{ $u->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-gray-400">{{ $u->email }}</td>
                            <td class="px-5 py-4">
                                @if ($u->role === 'admin')
                                    <span class="text-xs px-2.5 py-1 rounded-full bg-purple-900/50 text-purple-400 font-medium">Admin</span>
                                @else
                                    <span class="text-xs px-2.5 py-1 rounded-full bg-gray-800 text-gray-400 font-medium">User</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-gray-500 text-xs">{{ $u->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-5 py-4">
                                @if ($u->suspended_at)
                                    <span class="text-xs px-2.5 py-1 rounded-full bg-red-900/50 text-red-400 font-medium">Suspended</span>
                                @else
                                    <span class="text-xs px-2.5 py-1 rounded-full bg-green-900/50 text-green-400 font-medium">Aktif</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Role Toggle --}}
                                    <form action="{{ route('admin.users.update-role', $u) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            onclick="return confirm('Ubah role {{ $u->name }} menjadi {{ $u->role === 'admin' ? 'User' : 'Admin' }}?')"
                                            class="text-xs px-3 py-1.5 rounded font-medium transition
                                                {{ $u->role === 'admin'
                                                    ? 'bg-gray-800 text-gray-400 hover:bg-gray-700'
                                                    : 'bg-purple-900/30 text-purple-400 hover:bg-purple-900/50' }}">
                                            {{ $u->role === 'admin' ? 'Jadikan User' : 'Jadikan Admin' }}
                                        </button>
                                    </form>

                                    {{-- Suspend / Unsuspend --}}
                                    @if ($u->suspended_at)
                                        <form action="{{ route('admin.users.unsuspend', $u) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-xs px-3 py-1.5 rounded font-medium bg-green-900/30 text-green-400 hover:bg-green-900/50 transition">
                                                Aktifkan
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.suspend', $u) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                onclick="return confirm('Suspend akun {{ $u->name }}?')"
                                                class="text-xs px-3 py-1.5 rounded font-medium bg-yellow-900/30 text-yellow-400 hover:bg-yellow-900/50 transition">
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
                                            class="text-xs px-3 py-1.5 rounded font-medium bg-red-900/30 text-red-400 hover:bg-red-900/50 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-gray-600 text-sm">
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
