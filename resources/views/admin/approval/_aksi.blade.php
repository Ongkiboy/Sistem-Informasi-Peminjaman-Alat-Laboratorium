<div class="flex justify-center gap-2 flex-wrap">

    @if($item->status === 'pending')
        {{-- Setujui --}}
        <form method="POST" action="{{ route('admin.approval.setujui', $item) }}">
            @csrf
            <button type="submit"
                    class="text-xs font-medium px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition">
                Setujui
            </button>
        </form>

        {{-- Tolak — trigger modal --}}
        <button
            type="button"
            onclick="tampilkanModalTolak({{ $item->id }}, '{{ addslashes($item->alat->nama_alat) }}', '{{ addslashes($item->pengguna->nama) }}')"
            class="text-xs font-medium px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white transition">
            Tolak
        </button>

    @elseif($item->status === 'approved')
        {{-- Konfirmasi Diambil --}}
        <form method="POST" action="{{ route('admin.approval.diambil', $item) }}">
            @csrf
            <button type="submit"
                    class="text-xs font-medium px-3 py-1.5 rounded-lg bg-purple-600 hover:bg-purple-700 text-white transition">
                Konfirmasi Diambil
            </button>
        </form>

    @elseif($item->status === 'borrowed')
        {{-- Konfirmasi Kembali --}}
        <form method="POST" action="{{ route('admin.approval.kembali', $item) }}">
            @csrf
            <button type="submit"
                    class="text-xs font-medium px-3 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 text-white transition">
                Konfirmasi Kembali
            </button>
        </form>

    @else
        {{-- returned / rejected — tidak ada tombol --}}
        <span class="text-xs text-gray-400">—</span>
    @endif

</div>