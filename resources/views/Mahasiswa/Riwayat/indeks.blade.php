<x-mahasiswa-layout>
    <x-slot name="title">Riwayat Peminjaman</x-slot>

    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800">Riwayat Peminjaman</h1>
        <p class="text-sm text-gray-500 mt-1">Semua riwayat pengajuan peminjaman kamu.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($riwayat->count() > 0)
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Alat</th>
                        <th class="text-center px-4 py-3 font-medium text-gray-600">Jml</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Tgl Pinjam</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Rencana Kembali</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Kembali Aktual</th>
                        <th class="text-center px-4 py-3 font-medium text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($riwayat as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-800">{{ $item->alat->nama_alat }}</p>
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
                                @php
                                    $badgeClass = match($item->status) {
                                        'pending'  => 'bg-yellow-100 text-yellow-700',
                                        'approved' => 'bg-blue-100 text-blue-700',
                                        'borrowed' => 'bg-purple-100 text-purple-700',
                                        'returned' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        default    => 'bg-gray-100 text-gray-600',
                                    };
                                    $badgeLabel = match($item->status) {
                                        'pending'  => 'Menunggu',
                                        'approved' => 'Disetujui',
                                        'borrowed' => 'Dipinjam',
                                        'returned' => 'Dikembalikan',
                                        'rejected' => 'Ditolak',
                                        default    => $item->status,
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                    {{ $badgeLabel }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-4 py-3 border-t border-gray-100">
                {{ $riwayat->links() }}
            </div>

        @else
            {{-- Empty State --}}
            <div class="text-center py-16 text-gray-400">
                <p class="text-lg font-medium">Belum ada riwayat peminjaman</p>
                <p class="text-sm mt-1">
                    <a href="{{ route('mahasiswa.katalog') }}" class="text-blue-500 hover:underline">
                        Lihat katalog alat
                    </a> dan ajukan peminjaman pertamamu.
                </p>
            </div>
        @endif
    </div>

</x-mahasiswa-layout>