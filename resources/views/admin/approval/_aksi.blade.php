<div class="flex justify-center gap-2 flex-wrap">

    @if($item->status === 'pending')
        {{-- Setujui --}}
        <form method="POST" action="{{ route('admin.approval.setujui', $item) }}">
            @csrf
            @method('PATCH')
            <x-tombol tipe="submit" ukuran="sm">Setujui</x-tombol>
        </form>

        {{-- Tolak --}}
        <x-dialog-konfirmasi
            judul="Tolak Pengajuan?"
            :pesan="'Yakin ingin menolak pengajuan '.$item->pengguna->nama.' untuk alat '.$item->alat->nama_alat.'? Stok akan dikembalikan otomatis.'"
            :aksiUrl="route('admin.approval.tolak', $item)"
            aksiMetode="PATCH"
            labelYa="Ya, Tolak">
            <x-slot:trigger>
                <x-tombol varian="bahaya" ukuran="sm" tipe="button">Tolak</x-tombol>
            </x-slot:trigger>
        </x-dialog-konfirmasi>

    @elseif($item->status === 'approved')
        {{-- Konfirmasi Diambil --}}
        <form method="POST" action="{{ route('admin.approval.diambil', $item) }}">
            @csrf
            @method('PATCH')
            <x-tombol varian="ungu" ukuran="sm" tipe="submit">Konfirmasi Diambil</x-tombol>
        </form>

    @elseif($item->status === 'borrowed')
        {{-- Konfirmasi Kembali --}}
        <form method="POST" action="{{ route('admin.approval.kembali', $item) }}" class="flex items-center gap-2">
            @csrf
            @method('PATCH')
            <select name="kondisi_kembali" class="text-xs border border-gray-300 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="baik">Baik</option>
                <option value="rusak_ringan">Rusak Ringan</option>
                <option value="rusak_berat">Rusak Berat</option>
            </select>
            <x-tombol varian="sukses" ukuran="sm" tipe="submit">Konfirmasi Kembali</x-tombol>
        </form>

    @else
        {{-- returned / rejected — tidak ada tombol --}}
        <span class="text-xs text-gray-400">—</span>
    @endif

</div>
