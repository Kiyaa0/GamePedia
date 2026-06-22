<x-guest-layout>
    <div class="min-h-screen bg-[#0f0f11] flex items-center justify-center px-4">
        <div class="w-full max-w-md">

            {{-- Logo --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white">GamePedia</h1>
                <p class="text-gray-400 text-sm mt-2">Masuk ke akunmu</p>
            </div>

            {{-- Card --}}
            <div class="bg-[#1a1a1a] border border-white/5 rounded-lg p-8">

                <x-auth-session-status class="mb-4 text-green-400 text-sm" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm text-gray-400 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full bg-[#1a1a1a] border border-white/5 rounded-md px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#E51920] transition">
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-[#E51920] text-xs" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-400 mb-1.5">Password</label>
                        <input type="password" name="password" required
                            class="w-full bg-[#1a1a1a] border border-white/5 rounded-md px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#E51920] transition">
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-[#E51920] text-xs" />
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded bg-[#1a1a1a] border-white/5 text-[#E51920]">
                            <span class="text-sm text-gray-400">Ingat saya</span>
                        </label>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-[#E51920] hover:text-red-300 transition">Lupa password?</a>
                        @endif
                    </div>

                    <button class="w-full bg-[#E51920] hover:bg-red-600 py-2.5 rounded-md text-sm font-semibold transition">
                        Masuk
                    </button>
                </form>
            </div>

            <p class="text-center text-gray-500 text-sm mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-[#E51920] hover:text-red-300 transition">Daftar sekarang</a>
            </p>

        </div>
    </div>
</x-guest-layout>
