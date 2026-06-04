<x-guest-layout>
    <div class="min-h-screen bg-gray-950 flex items-center justify-center px-4">
        <div class="w-full max-w-md">

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white">GamePedia</h1>
                <p class="text-gray-400 text-sm mt-2">Buat akun baru</p>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-lg p-8">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm text-gray-400 mb-1.5">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-red-400 text-xs" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-400 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-red-400 text-xs" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-400 mb-1.5">Password</label>
                        <input type="password" name="password" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-red-400 text-xs" />
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm text-gray-400 mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-red-400 text-xs" />
                    </div>

                    <button class="w-full bg-blue-600 hover:bg-blue-700 py-2.5 rounded-md text-sm font-semibold transition">
                        Daftar
                    </button>
                </form>
            </div>

            <p class="text-center text-gray-500 text-sm mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 transition">Masuk</a>
            </p>

        </div>
    </div>
</x-guest-layout>