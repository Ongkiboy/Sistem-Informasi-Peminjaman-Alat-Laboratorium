<x-admin-layout>
    <x-slot name="title">Edit Alat</x-slot>

    <div class="max-w-2xl">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.alat.indeks') }}" class="text-gray-400 hover:text-gray-600 text-sm transition-colors duration-150">
                ← Kembali
            </a>
            <h1 class="text-xl font-bold text-gray-900">Edit Alat</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form method="PUT" action="{{ route('admin.alat.perbarui', $alat) }}">
                @csrf
                @method('PUT')

                <x-input-form label="Nama Alat" nama="nama_alat" wajib :value="old('nama_alat', $alat->nama_alat)" />

                <x-input-form label="Kode Barang" nama="kode_barang" wajib class="font-mono" :value="old('kode_barang', $alat->kode_barang)" />

                {{-- Kondisi dan Total Stok --}}
                <div class="grid grid-cols-2 gap-4">
                    <x-input-form label="Kondisi" nama="kondisi" tipe="select" wajib>
                        <option value="baik" @selected(old('kondisi', $alat->kondisi) === 'baik')>Baik</option>
                        <option value="rusak_ringan" @selected(old('kondisi', $alat->kondisi) === 'rusak_ringan')>Rusak Ringan</option>
                        <option value="rusak_berat" @selected(old('kondisi', $alat->kondisi) === 'rusak_berat')>Rusak Berat</option>
                    </x-input-form>

                    <x-input-form label="Total Stok" nama="total_stok" tipe="number" wajib :value="old('total_stok', $alat->total_stok)" min="1" max="9999" />
                </div>

                {{-- Stok Tersedia — READ ONLY --}}
                <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-medium text-gray-500 mb-1">Stok Tersedia (dikelola sistem)</p>
                    <p class="text-sm font-semibold text-gray-700">{{ $alat->stok_tersedia }} unit</p>
                    <p class="text-xs text-gray-400 mt-1">Nilai ini tidak bisa diedit manual.</p>
                </div>

                <x-input-form label="Deskripsi" nama="deskripsi" tipe="textarea" :value="old('deskripsi', $alat->deskripsi)" />

                <div class="flex gap-3 justify-end mt-2">
                    <x-tombol varian="sekunder" :href="route('admin.alat.indeks')">Batal</x-tombol>
                    <x-tombol tipe="submit">Simpan Perubahan</x-tombol>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
