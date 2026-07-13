<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIPLAB</title>
    <!-- Tailwind CSS CDN sebagai fallback agar tampilan langsung rapi di preview / lokal -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center relative overflow-hidden p-4">
    
    <!-- Elemen Dekoratif Lab di Latar Belakang (Dibatasi ukurannya secara ketat via inline style agar tidak melar) -->
    <div class="absolute inset-0 pointer-events-none opacity-25 z-0">
        
        <!-- Tabung Reaksi Floating SVG Kiri -->
        <svg class="absolute top-12 left-10 text-blue-500 animate-pulse hidden md:block" 
             style="width: 96px; height: 96px;" 
             fill="none" 
             viewBox="0 0 24 24" 
             stroke="currentColor" 
             stroke-width="1.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
        </svg>

        <!-- Struktur Molekul SVG Kanan -->
        <svg class="absolute bottom-12 right-10 text-indigo-400 animate-bounce hidden md:block" 
             style="width: 120px; height: 120px; animation-duration: 6s;" 
             fill="none" 
             viewBox="0 0 24 24" 
             stroke="currentColor" 
             stroke-width="1.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m11.314 11.314l.707.707M12 5a7 7 0 100 14 7 7 0 000-14z" />
        </svg>

        <!-- Pola Grid Halus di Latar Belakang -->
        <div class="absolute inset-0 bg-[radial-gradient(#cbd5e1_1.2px,transparent_1.2px)] [background-size:20px_20px]"></div>
    </div>

    <!-- Container Utama Kartu Login -->
    <div class="relative z-10 w-full max-w-md" style="max-width: 440px;">
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-slate-100 p-8 sm:p-10 mx-auto">

            {{-- Logo / Header --}}
            <div class="text-center mb-8">
                <!-- Wadah Ikon Lab Representatif -->
                <div class="inline-flex items-center justify-center rounded-2xl bg-blue-50 text-blue-600 mb-4 ring-8 ring-blue-50/50" 
                     style="width: 56px; height: 56px;">
                    <svg style="width: 28px; height: 28px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <!-- Lab flask icon -->
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-800">SIPLAB</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1.5 font-medium">Sistem Informasi Peminjaman Alat Lab</p>
                <div class="h-1 w-12 bg-blue-600 mx-auto mt-4 rounded-full"></div>
            </div>

            {{-- Flash Error Global --}}
            @if (session('error'))
                <div class="bg-red-50 border border-red-100 text-red-700 rounded-xl px-4 py-3.5 mb-5 text-sm flex items-start gap-3">
                    <svg style="width: 20px; height: 20px;" class="text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Form Login --}}
            <form method="POST" action="{{ route('login.proses') }}" class="space-y-5">
                @csrf

                {{-- Email Input --}}
                <div>
                    <label for="email" class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">
                        Alamat Email Resmi
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full pl-10 pr-3 py-2.5 text-sm bg-slate-50 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-150
                                   {{ $errors->has('email') ? 'border-red-400 focus:ring-red-500/20' : 'border-slate-200' }}"
                            placeholder="nama@univ.ac.id"
                            autofocus
                        >
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                            <span class="inline-block rounded-full bg-red-500" style="width: 4px; height: 4px;"></span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password Input --}}
                <div>
                    <label for="password" class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full pl-10 pr-3 py-2.5 text-sm bg-slate-50 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-150
                                   {{ $errors->has('password') ? 'border-red-400 focus:ring-red-500/20' : 'border-slate-200' }}"
                            placeholder="••••••••"
                        >
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                            <span class="inline-block rounded-full bg-red-500" style="width: 4px; height: 4px;"></span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Remember Me Option --}}
                <div class="flex items-center justify-between text-xs sm:text-sm pt-1">
                    <label class="flex items-center text-slate-600 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500/20 mr-2" style="width: 16px; height: 16px;">
                        Ingat Saya
                    </label>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl text-sm transition-all duration-150 transform active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-blue-500/40 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 flex items-center justify-center gap-2"
                >
                    <span>Masuk ke Akun</span>
                    <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </button>
            </form>

            {{-- Footer Bantuan --}}
            <div class="mt-8 text-center border-t border-slate-100 pt-5">
                <p class="text-xs text-slate-400">
                    Butuh bantuan akses? Silakan hubungi <a href="#" class="text-blue-500 hover:underline font-medium">Laboran</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>