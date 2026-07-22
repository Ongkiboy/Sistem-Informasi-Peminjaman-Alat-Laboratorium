@props([
    'varian' => 'primer', // primer | sekunder | bahaya | ungu | sukses
    'ukuran' => 'md',     // sm | md | lg
    'tipe' => 'button',
    'href' => null,
    'disabled' => false,
])

@php
    $base = 'inline-flex items-center justify-center gap-1.5 font-semibold rounded-lg transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed focus:outline-none';

    $varianClass = match ($varian) {
        'sekunder' => 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-gray-300',
        'bahaya'   => 'bg-red-600 text-white hover:bg-red-700 focus:ring-2 focus:ring-red-500',
        'ungu'     => 'bg-purple-600 text-white hover:bg-purple-700 focus:ring-2 focus:ring-purple-500',
        'sukses'   => 'bg-green-600 text-white hover:bg-green-700 focus:ring-2 focus:ring-green-500',
        default    => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500',
    };

    $ukuranClass = match ($ukuran) {
        'sm' => 'text-xs px-3 py-1.5',
        'lg' => 'text-base px-6 py-3',
        default => 'text-sm px-4 py-2',
    };
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->class([$base, $varianClass, $ukuranClass]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $tipe }}" @disabled($disabled)
            {{ $attributes->class([$base, $varianClass, $ukuranClass]) }}>
        {{ $slot }}
    </button>
@endif
