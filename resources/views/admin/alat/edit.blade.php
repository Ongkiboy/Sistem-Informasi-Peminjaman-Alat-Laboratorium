<x-admin-layout>
    <x-slot name="title">Edit Alat</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.alat.indeks') }}" class="text-gray-400 hover:text-gray-600 text-sm transition-colors duration-150">
                ← Kembali
            </a>
            <h1 class="text-xl font-bold text-gray-900">Edit Alat</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('admin.alat.perbarui', $alat) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <x-input-form label="Nama Alat" nama="nama_alat" wajib :value="old('nama_alat', $alat->nama_alat)" />
                @if($alat->gambar_url)
                    <div class="mb-4">
                        <p class="block text-sm font-medium text-gray-700 mb-1">Gambar Saat Ini</p>
                        <img src="{{ $alat->gambar_url }}" class="h-24 w-24 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif

                <x-input-form label="Ganti Gambar" nama="gambar" tipe="file" bantuan="Kosongkan kalau tidak mau ganti gambar." />
                <x-input-form label="Kode Barang" nama="kode_barang" wajib class="font-mono" :value="old('kode_barang', $alat->kode_barang)" />

                {{-- Breakdown stok per kondisi (3 kolom) --}}
                <div class="grid grid-cols-3 gap-4">
                    <x-input-form label="Stok Baik" nama="stok_baik" tipe="number" wajib :value="old('stok_baik', $alat->stok_baik)" min="0" max="9999" />
                    <x-input-form label="Stok Rusak Ringan" nama="stok_rusak_ringan" tipe="number" wajib :value="old('stok_rusak_ringan', $alat->stok_rusak_ringan)" min="0" max="9999" />
                    <x-input-form label="Stok Rusak Berat" nama="stok_rusak_berat" tipe="number" wajib :value="old('stok_rusak_berat', $alat->stok_rusak_berat)" min="0" max="9999" />
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
