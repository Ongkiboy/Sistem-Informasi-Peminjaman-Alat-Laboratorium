@props(['alat'])

@php
    $kondisiConfig = [
        'baik'         => ['badge' => 'bg-green-100 text-green-700', 'dot' => 'bg-green-500',  'label' => 'Baik'],
        'rusak_ringan' => ['badge' => 'bg-yellow-100 text-yellow-700','dot' => 'bg-yellow-500', 'label' => 'Rusak Ringan'],
        'rusak_berat'  => ['badge' => 'bg-red-100 text-red-700',     'dot' => 'bg-red-500',    'label' => 'Rusak Berat'],
    ][$alat->kondisi] ?? ['badge' => 'bg-gray-100 text-gray-700', 'dot' => 'bg-gray-400', 'label' => $alat->kondisi];

    $headerBg = match($alat->kondisi) {
        'baik'         => 'from-blue-50 to-indigo-100',
        'rusak_ringan' => 'from-yellow-50 to-amber-100',
        'rusak_berat'  => 'from-red-50 to-rose-100',
        default        => 'from-gray-50 to-gray-100',
    };

    $stokHabis = $alat->stok_tersedia <= 0;
@endphp

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden
            hover:border-blue-400 hover:shadow-lg
            transition-all duration-200 group flex flex-col">

    {{-- Header area --}}
    <div class="h-24 bg-gradient-to-br {{ $headerBg }} flex items-center justify-center relative">
        <span class="text-4xl select-none">🔬</span>

        <span class="absolute top-2 right-2 text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $kondisiConfig['badge'] }}">
            {{ $kondisiConfig['label'] }}
        </span>
    </div>

    {{-- Content area --}}
    <div class="p-4 flex flex-col flex-1">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest font-mono">
            {{ $alat->kode_barang }}
        </p>
        <h3 class="text-base font-semibold text-gray-900 mt-1 leading-tight
                   group-hover:text-blue-600 transition-colors duration-200">
            {{ $alat->nama_alat }}
        </h3>

        {{-- Stok indicator --}}
        <div class="mt-3 flex items-center gap-1.5">
            <span class="h-2 w-2 rounded-full flex-shrink-0 {{ $stokHabis ? 'bg-red-400' : $kondisiConfig['dot'] }}"></span>
            <span class="text-sm {{ $stokHabis ? 'text-red-500 font-medium' : 'text-gray-600' }}">
                @if($stokHabis) Stok habis @else {{ $alat->stok_tersedia }} unit tersedia @endif
            </span>
        </div>

        {{-- Tombol --}}
        <div class="mt-auto pt-4">
            @if($stokHabis)
                <button disabled
                    class="w-full py-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed text-sm font-semibold">
                    Stok Habis
                </button>
            @else
                <a href="{{ route('mahasiswa.peminjaman.form', $alat) }}"
                   class="flex items-center justify-center gap-1.5 w-full py-2 rounded-lg
                          bg-blue-600 text-white text-sm font-semibold
                          hover:bg-blue-700 group-hover:scale-[1.02]
                          transition-all duration-200">
                    Pinjam <span class="text-blue-200">→</span>
                </a>
            @endif
        </div>
    </div>
</div>
