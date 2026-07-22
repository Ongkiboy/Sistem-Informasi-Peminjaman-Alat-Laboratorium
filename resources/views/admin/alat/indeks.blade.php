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
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama Alat</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Kode</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Kondisi</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Stok</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tersedia</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($alat as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $item->nama_alat }}</td>
                                <td class="px-4 py-3 text-gray-600 font-mono text-xs">{{ $item->kode_barang }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            {{ $item->stok_baik }} baik
                                        </span>
                                        @if($item->stok_rusak_ringan > 0)
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                                {{ $item->stok_rusak_ringan }} ringan
                                            </span>
                                        @endif
                                        @if($item->stok_rusak_berat > 0)
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                {{ $item->stok_rusak_berat }} berat
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-700">{{ $item->total_stok }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="{{ $item->stok_tersedia > 0 ? 'text-green-600' : 'text-red-500' }} font-semibold">
                                        {{ $item->stok_tersedia }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-2 items-center">
                                        <x-tombol varian="sekunder" ukuran="sm" :href="route('admin.alat.edit', $item)">Edit</x-tombol>
                                        <x-dialog-konfirmasi
                                            judul="Hapus Alat?"
                                            :pesan="'Yakin ingin menghapus alat '.$item->nama_alat.'? Alat yang dihapus tidak akan muncul di katalog.'"
                                            :aksiUrl="route('admin.alat.hapus', $item)"
                                            aksiMetode="DELETE"
                                            labelYa="Ya, Hapus">
                                            <x-slot:trigger>
                                                <x-tombol varian="bahaya" ukuran="sm" tipe="button">Hapus</x-tombol>
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
                <x-kondisi-kosong judul="Belum ada alat terdaftar" pesan="Tambahkan alat pertama untuk memulai." />
            </div>
        @endif
    </div>

</x-admin-layout>
