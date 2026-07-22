<x-mahasiswa-layout>
    <x-slot name="title">Riwayat Peminjaman</x-slot>

    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900">Riwayat Peminjaman</h1>
        <p class="text-sm text-gray-500 mt-1">Semua riwayat pengajuan peminjaman kamu.</p>
    </div>

    @if($riwayat->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Alat</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jml</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tgl Pinjam</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Rencana Kembali</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Kembali Aktual</th>
                            <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($riwayat as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-900">{{ $item->alat->nama_alat }}</p>
                                    <p class="text-xs text-gray-400 font-mono">{{ $item->alat->kode_barang }}</p>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-700">{{ $item->jumlah }}</td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $item->tanggal_pinjam->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $item->tanggal_rencana_kembali->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $item->tanggal_kembali_aktual ? $item->tanggal_kembali_aktual->format('d M Y') : '—' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <x-lencana-status :status="$item->status" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-100">
                {{ $riwayat->links() }}
            </div>
        </div>
    @else
        <x-kondisi-kosong
            judul="Belum ada riwayat"
            pesan="Yuk mulai pinjam alat pertamamu dari katalog!"
            ctaLabel="Lihat Katalog"
            :ctaHref="route('mahasiswa.katalog')" />
    @endif

</x-mahasiswa-layout>
