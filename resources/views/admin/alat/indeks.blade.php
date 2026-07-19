<x-admin-layout>
    <x-slot name="title">Manajemen Alat</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-gray-900">Daftar Alat</h1>
        <x-tombol :href="route('admin.alat.tambah')">+ Tambah Alat</x-tombol>
    </div>

    {{-- Search --}}
    <form method="GET" class="mb-4">
        <div class="flex gap-2">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari nama atau kode barang..."
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full max-w-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
            <x-tombol varian="sekunder" tipe="submit">Cari</x-tombol>
            @if(request('q'))
                <a href="{{ route('admin.alat.indeks') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 flex items-center px-2 transition-colors duration-150">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($alat->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-4 py-3 font-medium text-gray-700">Nama Alat</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-700">Kode</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-700">Kondisi</th>
                            <th class="text-center px-4 py-3 font-medium text-gray-700">Total Stok</th>
                            <th class="text-center px-4 py-3 font-medium text-gray-700">Tersedia</th>
                            <th class="text-center px-4 py-3 font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($alat as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $item->nama_alat }}</td>
                                <td class="px-4 py-3 text-gray-600 font-mono text-xs">{{ $item->kode_barang }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $kondisiClass = match($item->kondisi) {
                                            'baik'          => 'bg-green-100 text-green-700',
                                            'rusak_ringan'  => 'bg-yellow-100 text-yellow-700',
                                            'rusak_berat'   => 'bg-red-100 text-red-700',
                                            default         => 'bg-gray-100 text-gray-700',
                                        };
                                        $kondisiLabel = match($item->kondisi) {
                                            'baik'          => 'Baik',
                                            'rusak_ringan'  => 'Rusak Ringan',
                                            'rusak_berat'   => 'Rusak Berat',
                                            default         => $item->kondisi,
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $kondisiClass }}">
                                        {{ $kondisiLabel }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-700">{{ $item->total_stok }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="{{ $item->stok_tersedia > 0 ? 'text-green-600' : 'text-red-500' }} font-semibold">
                                        {{ $item->stok_tersedia }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-3 items-center">
                                        <a href="{{ route('admin.alat.edit', $item) }}"
                                           class="text-blue-600 hover:text-blue-800 text-xs font-medium transition-colors duration-150">
                                            Edit
                                        </a>
                                        <x-dialog-konfirmasi
                                            judul="Hapus Alat?"
                                            :pesan="'Yakin ingin menghapus alat '.$item->nama_alat.'? Alat yang dihapus tidak akan muncul di katalog.'"
                                            :aksiUrl="route('admin.alat.hapus', $item)"
                                            aksiMetode="DELETE"
                                            labelYa="Ya, Hapus">
                                            <x-slot:trigger>
                                                <button type="button" class="text-red-500 hover:text-red-700 text-xs font-medium transition-colors duration-150">
                                                    Hapus
                                                </button>
                                            </x-slot:trigger>
                                        </x-dialog-konfirmasi>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-100">
                {{ $alat->links() }}
            </div>

        @else
            <div class="p-6">
                <x-kondisi-kosong ikon="📦" judul="Belum ada alat terdaftar" pesan="Tambahkan alat pertama untuk memulai." />
            </div>
        @endif
    </div>

</x-admin-layout>
