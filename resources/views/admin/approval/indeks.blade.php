<x-admin-layout>
    <x-slot name="title">Daftar Pengajuan</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-gray-900">Daftar Pengajuan Peminjaman</h1>
    </div>

    {{-- Filter Tab Status --}}
    <div class="flex gap-2 mb-5 flex-wrap overflow-x-auto pb-1 -mx-1 px-1">
        @foreach(['semua' => 'Semua', 'pending' => 'Menunggu', 'approved' => 'Disetujui', 'borrowed' => 'Dipinjam', 'returned' => 'Dikembalikan', 'rejected' => 'Ditolak'] as $value => $label)
            @php $count = $jumlahPerStatus[$value] ?? null; @endphp
            <a href="{{ route('admin.approval.indeks', ['status' => $value]) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap transition-all duration-150
                      {{ $statusFilter === $value
                         ? 'bg-blue-600 text-white shadow-sm'
                         : 'bg-white border border-gray-200 text-gray-700 hover:border-blue-400' }}">
                {{ $label }}
                @if($count !== null)
                    <span class="ml-1 text-xs {{ $statusFilter === $value ? 'text-blue-100' : 'text-gray-400' }}">
                        {{ $count }}
                    </span>
                @endif
            </a>
        @endforeach
    </div>

    {{-- Tabel Pengajuan --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($peminjaman->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-4 py-3 font-medium text-gray-700">Mahasiswa</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-700">NIM</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-700">Alat</th>
                            <th class="text-center px-4 py-3 font-medium text-gray-700">Jml</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-700">Tgl Pinjam</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-700">Tgl Rencana Kembali</th>
                            <th class="text-center px-4 py-3 font-medium text-gray-700">Status</th>
                            <th class="text-center px-4 py-3 font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($peminjaman as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $item->pengguna->nama }}
                                </td>
                                <td class="px-4 py-3 text-gray-500 font-mono text-xs">
                                    {{ $item->pengguna->nim ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $item->alat->nama_alat }}
                                    <div class="text-xs text-gray-400 font-mono">{{ $item->alat->kode_barang }}</div>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-700">{{ $item->jumlah }}</td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $item->tanggal_pinjam->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $item->tanggal_rencana_kembali->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <x-lencana-status :status="$item->status" />
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @include('admin.approval._aksi', ['item' => $item])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-100">
                {{ $peminjaman->links() }}
            </div>

        @else
            <div class="p-6">
                <x-kondisi-kosong
                    ikon="✅"
                    pesan="Tidak ada pengajuan dengan filter ini."
                    :ctaLabel="$statusFilter !== 'semua' ? 'Lihat semua pengajuan' : null"
                    :ctaHref="$statusFilter !== 'semua' ? route('admin.approval.indeks', ['status' => 'semua']) : null" />
            </div>
        @endif
    </div>

</x-admin-layout>
