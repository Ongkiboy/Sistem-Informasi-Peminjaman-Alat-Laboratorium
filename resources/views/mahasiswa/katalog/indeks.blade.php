<x-mahasiswa-layout>
    <x-slot name="title">Katalog Alat</x-slot>

    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800">Katalog Alat</h1>
        <p class="text-sm text-gray-500 mt-1">Pilih alat yang ingin dipinjam.</p>
    </div>

    {{-- Search Form --}}
    <form method="GET" class="mb-6">
        <div class="flex gap-2">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari nama atau kode alat..."
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full max-w-md focus:outline-none focus:ring-2 focus:ring-blue-500"
>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ route('mahasiswa.katalog') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 flex items-center px-2">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Grid Katalog --}}
    @if($alat->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6">
            @foreach($alat as $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex flex-col justify-between">

                    {{-- Header Card --}}
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs text-gray-400 font-mono">{{ $item->kode_barang }}</span>
                            {{-- Badge kondisi --}}
                            @php
                                $kondisiClass = match($item->kondisi) {
                                    'baik'          => 'bg-green-100 text-green-700',
                                    'rusak_ringan'  => 'bg-yellow-100 text-yellow-700',
                                    'rusak_berat'   => 'bg-red-100 text-red-700',
                                    default         => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $kondisiClass }}">
                                {{ ucwords(str_replace('_', ' ', $item->kondisi)) }}
                            </span>
                        </div>
                        <h3 class="font-semibold text-gray-800 text-sm leading-snug mb-3">
                            {{ $item->nama_alat }}
                        </h3>
                    </div>

                    {{-- Footer Card --}}
                    <div>
                        {{-- Stok Badge --}}
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs text-gray-500">Stok:</span>
                            @if($item->stok_tersedia > 0)
                                <span class="text-xs font-semibold text-green-600">
                                    {{ $item->stok_tersedia }} tersedia
                                </span>
                            @else
                                <span class="text-xs font-semibold text-red-500">Stok Habis</span>
                            @endif
                        </div>

                        {{-- Tombol Pinjam --}}
                        @if($item->stok_tersedia > 0)
                            <a href="{{ route('mahasiswa.peminjaman.form', $item) }}"
                               class="block w-full text-center text-sm font-medium py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition">
                                Pinjam
                            </a>
                        @else
                            <button disabled
                                    class="block w-full text-center text-sm font-medium py-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        {{ $alat->links() }}

    @else
        {{-- Empty State --}}
        <div class="text-center py-20 text-gray-400">
            @if(request('q'))
                <p class="text-lg font-medium">Tidak ada alat dengan kata kunci "{{ request('q') }}"</p>
                <p class="text-sm mt-1">Coba kata kunci lain atau <a href="{{ route('mahasiswa.katalog') }}" class="text-blue-500 hover:underline">lihat semua alat</a>.</p>
            @else
                <p class="text-lg font-medium">Belum ada alat tersedia</p>
                <p class="text-sm mt-1">Hubungi laboran untuk informasi lebih lanjut.</p>
            @endif
        </div>
    @endif

</x-mahasiswa-layout>