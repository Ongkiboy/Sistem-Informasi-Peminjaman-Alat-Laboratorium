@props([
    'trigger',
    'judul' => 'Konfirmasi',
    'pesan' => 'Yakin ingin melanjutkan?',
    'aksiUrl',
    'aksiMetode' => 'POST',
    'labelYa' => 'Ya, Lanjutkan',
    'varianYa' => 'bahaya',
])

<div x-data="{ buka: false }" class="inline">
    <div @click="buka = true">{{ $trigger }}</div>

    <div x-show="buka" x-cloak
         x-transition.opacity
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
         @keydown.escape.window="buka = false">
        <div x-show="buka" x-transition
             class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6" @click.outside="buka = false">
            <h3 class="text-lg font-semibold text-gray-900">{{ $judul }}</h3>
            <p class="text-sm text-gray-600 mt-2">{{ $pesan }}</p>

            <form action="{{ $aksiUrl }}" method="POST" class="mt-6 flex justify-end gap-2">
                @csrf
                @if($aksiMetode !== 'POST') @method($aksiMetode) @endif
                <x-tombol varian="sekunder" @click="buka = false" tipe="button">Batal</x-tombol>
                <x-tombol varian="{{ $varianYa }}" tipe="submit">{{ $labelYa }}</x-tombol>
            </form>
        </div>
    </div>
</div>
