<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIPLAB')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- Navbar --}}
    @yield('navbar')

    {{-- Flash Messages --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="bg-blue-50 border border-blue-200 text-blue-700 rounded-lg px-4 py-3 text-sm mb-4">
                {{ session('info') }}
            </div>
        @endif
    </div>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        {{ $slot }}
    </main>

    @stack('scripts')
</body>
</html>