<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIPLAB</title>
    @include('partials.head-assets')
</head>
<body class="min-h-screen flex">

    {{-- Panel kiri — branding (desktop only) --}}
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-indigo-700 flex-col items-center justify-center p-12 relative overflow-hidden">
        <div class="absolute -top-16 -left-16 h-64 w-64 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-16 -right-16 h-80 w-80 rounded-full bg-white/5"></div>
        <div class="absolute inset-0 opacity-20"
             style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>

        <div class="relative text-center text-white">
            <div class="inline-flex h-20 w-20 rounded-2xl bg-white/10 items-center justify-center mb-4">
                <x-ikon nama="beaker" ukuran="xl" />
            </div>
            <h1 class="text-4xl font-bold">SIPLAB</h1>
            <p class="text-blue-100 mt-3 text-lg">Sistem Informasi Peminjaman<br>Alat Laboratorium</p>

            <div class="mt-10 space-y-3 text-left">
                @foreach(['Pantau stok alat real-time', 'Ajukan peminjaman kapan saja', 'Approval cepat dari admin'] as $fitur)
                    <div class="flex items-center gap-3 text-blue-100">
                        <span class="h-5 w-5 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                            <x-ikon nama="check" ukuran="xs" />
                        </span>
                        <span class="text-sm">{{ $fitur }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Panel kanan — form --}}
    <div class="flex-1 flex items-center justify-center p-6 bg-gray-50">
        <div class="w-full max-w-sm">
            {{-- Logo mobile only --}}
            <div class="text-center mb-8 lg:hidden">
                <div class="inline-flex h-14 w-14 rounded-2xl bg-blue-50 items-center justify-center text-blue-600">
                    <x-ikon nama="beaker" ukuran="lg" />
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mt-2">SIPLAB</h1>
                <p class="text-sm text-gray-500">Sistem Informasi Peminjaman Alat Laboratorium</p>
            </div>

            <h2 class="text-xl font-bold text-gray-900 mb-1">Selamat datang</h2>
            <p class="text-sm text-gray-500 mb-6">Masuk untuk melanjutkan</p>

            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">

                {{-- Flash Error Global --}}
                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-5 text-sm flex items-start gap-2">
                        <x-ikon nama="exclamation-triangle" ukuran="sm" class="flex-shrink-0" />
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.proses') }}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat Email <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            autofocus
                            placeholder="nama@univ.ac.id"
                            class="w-full border rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200
                                   {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}">
                        @error('email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div x-data="{ tampil: false }">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                :type="tampil ? 'text' : 'password'"
                                id="password"
                                name="password"
                                placeholder="••••••••"
                                class="w-full border rounded-lg px-3 py-2.5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200
                                       {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}">
                            <button type="button" @click="tampil = !tampil" aria-label="Tampilkan password"
                                    class="absolute right-0 inset-y-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition-colors duration-150">
                                <span x-show="!tampil" x-cloak><x-ikon nama="eye" ukuran="sm" /></span>
                                <span x-show="tampil" x-cloak><x-ikon nama="eye-slash" ukuran="sm" /></span>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center justify-between text-sm pt-1">
                        <label class="flex items-center text-gray-600 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2 h-4 w-4">
                            Ingat Saya
                        </label>
                    </div>

                    <x-tombol tipe="submit" class="w-full" ukuran="lg">
                        Masuk ke Akun →
                    </x-tombol>
                </form>

                <div class="mt-6 text-center border-t border-gray-100 pt-5">
                    <p class="text-xs text-gray-400">
                        Butuh bantuan akses? Silakan hubungi <a href="#" class="text-blue-600 hover:underline font-medium">Laboran</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
