<x-admin-layout>
    <x-slot name="title">Manajemen Alat</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-gray-800">Daftar Alat</h1>
        <a href="{{ route('admin.alat.tambah') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            + Tambah Alat
        </a>
    </div>

    {{-- Search --}}
    <form method="GET" class="mb-4">
        <div class="flex gap-2">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari nama atau kode barang..."
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full max-w-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
>
            <button type="submit"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-4 py-2 rounded-lg border border-gray-300 transition">
                Cari
            </button>
            @if(request('q'))
                <a href="{{ route('admin.alat.indeks') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 flex items-center px-2">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($alat->count() > 0)
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Nama Alat</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Kode</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Kondisi</th>
                        <th class="text-center px-4 py-3 font-medium text-gray-600">Total Stok</th>
                        <th class="text-center px-4 py-3 font-medium text-gray-600">Tersedia</th>
                        <th class="text-center px-4 py-3 font-medium text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($alat as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $item->nama_alat }}</td>
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
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.alat.edit', $item) }}"
                                       class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                        Edit
                                    </a>
                                    {{-- Tombol hapus dengan konfirmasi modal --}}
                                    <button
                                        type="button"
                                        onclick="tampilkanModalHapus({{ $item->id }}, '{{ $item->nama_alat }}')"
                                        class="text-red-500 hover:text-red-700 text-xs font-medium">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $alat->links() }}
            </div>

        @else
            {{-- Empty State --}}
            <div class="text-center py-16 text-gray-400">
                <p class="text-lg font-medium">Belum ada alat terdaftar</p>
                <p class="text-sm mt-1">Tambahkan alat pertama untuk memulai.</p>
            </div>
        @endif
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div id="modalHapus" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-sm mx-4">
            <h3 class="font-bold text-gray-800 mb-2">Konfirmasi Hapus</h3>
            <p class="text-sm text-gray-600 mb-6">
                Yakin ingin menghapus alat <strong id="namaAlatHapus"></strong>?
                Alat yang dihapus tidak akan muncul di katalog.
            </p>
            <div class="flex gap-3 justify-end">
                <button onclick="tutupModalHapus()"
                        class="text-sm px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                    Batal
                </button>
                <form id="formHapus" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-sm px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function tampilkanModalHapus(id, nama) {
            document.getElementById('namaAlatHapus').textContent = nama;
            document.getElementById('formHapus').action = `/admin/alat/${id}`;
            document.getElementById('modalHapus').classList.remove('hidden');
        }
        function tutupModalHapus() {
            document.getElementById('modalHapus').classList.add('hidden');
        }
    </script>
    @endpush

</x-admin-layout>