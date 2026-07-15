<x-admin-layout>
    <x-slot name="title">Daftar Pengajuan</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-gray-800">Daftar Pengajuan Peminjaman</h1>
    </div>

    {{-- Filter Tab Status --}}
    <div class="flex gap-1 mb-5 flex-wrap">
        @foreach(['semua' => 'Semua', 'pending' => 'Pending', 'approved' => 'Approved', 'borrowed' => 'Dipinjam', 'returned' => 'Dikembalikan', 'rejected' => 'Ditolak'] as $value => $label)
            <a href="{{ route('admin.approval.indeks', ['status' => $value]) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium transition
                      {{ $statusFilter === $value
                         ? 'bg-blue-600 text-white'
                         : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Tabel Pengajuan --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($peminjaman->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">Mahasiswa</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">NIM</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">Alat</th>
                            <th class="text-center px-4 py-3 font-medium text-gray-600">Jml</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">Tgl Pinjam</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">Tgl Rencana Kembali</th>
                            <th class="text-center px-4 py-3 font-medium text-gray-600">Status</th>
                            <th class="text-center px-4 py-3 font-medium text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($peminjaman as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-medium text-gray-800">
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
                                    @php
                                        $badgeClass = match($item->status) {
                                            'pending'  => 'bg-yellow-100 text-yellow-800',
                                            'approved' => 'bg-blue-100 text-blue-800',
                                            'borrowed' => 'bg-purple-100 text-purple-800',
                                            'returned' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default    => 'bg-gray-100 text-gray-800',
                                        };
                                        $badgeLabel = match($item->status) {
                                            'pending'  => 'Pending',
                                            'approved' => 'Approved',
                                            'borrowed' => 'Dipinjam',
                                            'returned' => 'Dikembalikan',
                                            'rejected' => 'Ditolak',
                                            default    => $item->status,
                                        };
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                        {{ $badgeLabel }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{-- Tombol aksi dikerjain di FE-APPROVAL-002 --}}
                                    @include('admin.approval._aksi', ['item' => $item])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $peminjaman->links() }}
            </div>

        @else
            {{-- Empty State --}}
            <div class="text-center py-16 text-gray-400">
                <p class="text-4xl mb-3">✅</p>
                <p class="text-base font-medium">Tidak ada pengajuan dengan filter ini.</p>
                @if($statusFilter !== 'semua')
                    <a href="{{ route('admin.approval.indeks', ['status' => 'semua']) }}"
                       class="mt-3 inline-block text-sm text-blue-600 hover:underline">
                        Lihat semua pengajuan
                    </a>
                @endif
            </div>
        @endif
    </div>

    {{-- Modal Konfirmasi Tolak (dikerjain di FE-APPROVAL-003) --}}
    @include('admin.approval._modal-tolak')

</x-admin-layout>