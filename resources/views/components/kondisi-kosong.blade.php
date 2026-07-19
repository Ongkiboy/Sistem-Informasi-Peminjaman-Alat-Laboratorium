@props(['ikon' => '📦', 'judul' => null, 'pesan', 'ctaLabel' => null, 'ctaHref' => null])

<div class="bg-white rounded-2xl border-2 border-dashed border-gray-200 py-16 px-6 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-30"
         style="background-image: radial-gradient(circle, #d1d5db 1px, transparent 1px); background-size: 20px 20px;">
    </div>

    <div class="relative">
        <div class="inline-flex h-20 w-20 rounded-full bg-blue-50 items-center justify-center text-4xl mb-4 mx-auto">
            {{ $ikon }}
        </div>

        @if($judul)
            <h3 class="text-lg font-semibold text-gray-900">{{ $judul }}</h3>
            <p class="text-sm text-gray-500 mt-1 max-w-xs mx-auto">{{ $pesan }}</p>
        @else
            <p class="text-sm font-medium text-gray-700 max-w-xs mx-auto">{{ $pesan }}</p>
        @endif

        @if($ctaLabel && $ctaHref)
            <a href="{{ $ctaHref }}"
               class="inline-flex items-center gap-1.5 mt-6 px-5 py-2.5
                      bg-blue-600 text-white text-sm font-semibold rounded-lg
                      hover:bg-blue-700 transition-colors duration-200">
                {{ $ctaLabel }} →
            </a>
        @endif
    </div>
</div>
