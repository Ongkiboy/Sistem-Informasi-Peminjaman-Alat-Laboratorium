<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-0.5">
            Ringkasan kondisi inventori dan peminjaman alat laboratorium.
        </p>
    </div>

    {{-- 4 Stat Card --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        {{-- Total Alat --}}
        <a href="{{ route('admin.alat.indeks') }}"
           class="bg-white rounded-xl border border-gray-200 p-5
                  hover:border-blue-400 hover:shadow-lg transition-all duration-200 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Alat</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $statistik['total_alat'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">jenis alat aktif</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-blue-100 flex items-center justify-center text-lg
                            group-hover:scale-110 transition-transform duration-200">
                    📦
                </div>
            </div>
        </a>

        {{-- Aktif Dipinjam --}}
        <a href="{{ route('admin.approval.indeks', ['status' => 'approved']) }}"
           class="bg-white rounded-xl border border-gray-200 p-5
                  hover:border-purple-400 hover:shadow-lg transition-all duration-200 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Aktif Dipinjam</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">{{ $statistik['peminjaman_aktif'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">approved + borrowed</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-purple-100 flex items-center justify-center text-lg
                            group-hover:scale-110 transition-transform duration-200">
                    🔬
                </div>
            </div>
        </a>

        {{-- Pending Hari Ini --}}
        <a href="{{ route('admin.approval.indeks', ['status' => 'pending']) }}"
           class="bg-white rounded-xl border border-gray-200 p-5
                  hover:border-yellow-400 hover:shadow-lg transition-all duration-200 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pending Hari Ini</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $statistik['pending_hari_ini'] }}</p>
                    @if($statistik['pending_hari_ini'] > 0)
                        <p class="text-xs text-yellow-600 font-medium mt-1 flex items-center gap-1">
                            <span class="h-1.5 w-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                            Perlu ditinjau
                        </p>
                    @else
                        <p class="text-xs text-green-600 mt-1">Semua beres ✅</p>
                    @endif
                </div>
                <div class="h-10 w-10 rounded-xl bg-yellow-100 flex items-center justify-center text-lg
                            group-hover:scale-110 transition-transform duration-200">
                    📋
                </div>
            </div>
        </a>

        {{-- Bulan Ini --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5
                    hover:shadow-lg transition-all duration-200 group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Bulan Ini</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $statistik['total_bulan_ini'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">total pengajuan</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-green-100 flex items-center justify-center text-lg
                            group-hover:scale-110 transition-transform duration-200">
                    📈
                </div>
            </div>
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
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left px-4 py-2.5 font-medium text-gray-600 text-xs">Mahasiswa</th>
                            <th class="text-left px-4 py-2.5 font-medium text-gray-600 text-xs">Alat</th>
                            <th class="text-center px-4 py-2.5 font-medium text-gray-600 text-xs">Jml</th>
                            <th class="text-left px-4 py-2.5 font-medium text-gray-600 text-xs">Waktu</th>
                            <th class="text-center px-4 py-2.5 font-medium text-gray-600 text-xs">Status</th>
                            <th class="text-center px-4 py-2.5 font-medium text-gray-600 text-xs">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($pengajuanTerbaru as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-3 text-gray-900">
                                    {{ $item->pengguna->nama }}
                                    <div class="text-xs text-gray-400 font-mono">{{ $item->pengguna->nim ?? '' }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $item->alat->nama_alat }}
                                </td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $item->jumlah }}</td>
                                <td class="px-4 py-3 text-gray-500 text-xs">{{ $item->created_at->diffForHumans() }}</td>
                                <td class="px-4 py-3 text-center">
                                    <x-lencana-status :status="$item->status" />
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
            <x-kondisi-kosong ikon="📋" pesan="Belum ada pengajuan peminjaman." />
        @endif
    </div>

</x-admin-layout>
