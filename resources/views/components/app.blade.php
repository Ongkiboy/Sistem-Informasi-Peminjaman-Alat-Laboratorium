@props(['title' => null])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title . ' — SIPLAB' : 'SIPLAB' }}</title>
    @include('partials.head-assets')
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">

    {{-- Navbar / Sidebar --}}
    {{ $navbar ?? '' }}

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <x-pesan-flash />
        {{ $slot }}
    </main>

    @stack('scripts')
</body>
</html>
