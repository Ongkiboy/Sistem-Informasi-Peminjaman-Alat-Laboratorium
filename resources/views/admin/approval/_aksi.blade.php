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
            <button type="submit"
                    class="text-xs font-medium px-3 py-1.5 rounded-lg bg-purple-600 hover:bg-purple-700 text-white transition-all duration-200">
                Konfirmasi Diambil
            </button>
        </form>

    @elseif($item->status === 'borrowed')
        {{-- Konfirmasi Kembali --}}
        <form method="POST" action="{{ route('admin.approval.kembali', $item) }}">
            @csrf
            @method('PATCH')
            <button type="submit"
                    class="text-xs font-medium px-3 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 text-white transition-all duration-200">
                Konfirmasi Kembali
            </button>
        </form>

    @else
        {{-- returned / rejected — tidak ada tombol --}}
        <span class="text-xs text-gray-400">—</span>
    @endif

</div>
