<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-0.5">
            Ringkasan kondisi inventori dan peminjaman alat laboratorium.
        </p>
    </div>

    {{-- 4 Stat Card --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        {{-- Total Alat --}}
        <a href="{{ route('admin.alat.indeks') }}"
           class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition block">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Total Alat</p>
            <p class="text-3xl font-bold text-gray-800">{{ $statistik['total_alat'] }}</p>
            <p class="text-xs text-gray-400 mt-1">jenis alat aktif</p>
        </a>

        {{-- Peminjaman Aktif --}}
        <a href="{{ route('admin.approval.indeks', ['status' => 'approved']) }}"
           class="bg-white rounded-xl border border-blue-200 shadow-sm p-5 hover:shadow-md transition block">
            <p class="text-xs font-medium text-blue-500 uppercase tracking-wide mb-1">Aktif Dipinjam</p>
            <p class="text-3xl font-bold text-blue-700">{{ $statistik['peminjaman_aktif'] }}</p>
            <p class="text-xs text-blue-400 mt-1">approved + borrowed</p>
        </a>

        {{-- Pending Hari Ini --}}
        <a href="{{ route('admin.approval.indeks', ['status' => 'pending']) }}"
           class="bg-white rounded-xl border border-yellow-200 shadow-sm p-5 hover:shadow-md transition block">
            <p class="text-xs font-medium text-yellow-600 uppercase tracking-wide mb-1">Pending Hari Ini</p>
            <p class="text-3xl font-bold text-yellow-700">{{ $statistik['pending_hari_ini'] }}</p>
            <p class="text-xs text-yellow-500 mt-1">menunggu persetujuan</p>
        </a>

        {{-- Total Bulan Ini --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Bulan Ini</p>
            <p class="text-3xl font-bold text-gray-800">{{ $statistik['total_bulan_ini'] }}</p>
            <p class="text-xs text-gray-400 mt-1">total pengajuan</p>
        </div>

    </div>

    {{-- Tabel Pengajuan Terbaru --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-sm font-semibold text-gray-700">Pengajuan Terbaru</h2>
            <a href="{{ route('admin.approval.indeks') }}"
               class="text-xs text-blue-600 hover:underline">
                Lihat semua →
            </a>
        </div>

        @if($pengajuanTerbaru->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left px-4 py-2.5 font-medium text-gray-500 text-xs uppercase tracking-wide">Mahasiswa</th>
                            <th class="text-left px-4 py-2.5 font-medium text-gray-500 text-xs uppercase tracking-wide">Alat</th>
                            <th class="text-center px-4 py-2.5 font-medium text-gray-500 text-xs uppercase tracking-wide">Jml</th>
                            <th class="text-center px-4 py-2.5 font-medium text-gray-500 text-xs uppercase tracking-wide">Status</th>
                            <th class="text-center px-4 py-2.5 font-medium text-gray-500 text-xs uppercase tracking-wide">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($pengajuanTerbaru as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-gray-800">
                                    {{ $item->pengguna->nama }}
                                    <div class="text-xs text-gray-400 font-mono">{{ $item->pengguna->nim ?? '' }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $item->alat->nama_alat }}
                                </td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $item->jumlah }}</td>
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
                                    <a href="{{ route('admin.approval.indeks', ['status' => $item->status]) }}"
                                       class="text-xs text-blue-600 hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 text-gray-400">
                <p class="text-sm">Belum ada pengajuan peminjaman.</p>
            </div>
        @endif
    </div>

    {{-- Modal Konfirmasi Tolak (dibutuhkan jika aksi langsung dari dashboard) --}}
    @include('admin.approval._modal-tolak')

</x-admin-layout>