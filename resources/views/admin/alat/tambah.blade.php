<x-admin-layout>
    <x-slot name="title">Tambah Alat</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.alat.indeks') }}" class="text-gray-400 hover:text-gray-600 text-sm transition-colors duration-150">
                ← Kembali
            </a>
            <h1 class="text-xl font-bold text-gray-900">Tambah Alat Baru</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('admin.alat.simpan') }}" enctype="multipart/form-data">
                @csrf

                <x-input-form label="Nama Alat" nama="nama_alat" wajib placeholder="cth: Mikroskop Binokuler" />
                <x-input-form label="Gambar Alat" nama="gambar" tipe="file" bantuan="Format JPG/PNG/WEBP, maks 2MB." />
                <x-input-form
                    label="Kode Barang"
                    nama="kode_barang"
                    wajib
                    class="font-mono"
                    placeholder="cth: MKR-001"
                    bantuan="Otomatis diubah ke huruf kapital. Hanya huruf, angka, dan tanda hubung." />

                {{-- Breakdown stok per kondisi (3 kolom) --}}
                <div class="grid grid-cols-3 gap-4">
                    <x-input-form label="Stok Baik" nama="stok_baik" tipe="number" wajib :value="old('stok_baik', 0)" min="0" max="9999" />
                    <x-input-form label="Stok Rusak Ringan" nama="stok_rusak_ringan" tipe="number" wajib :value="old('stok_rusak_ringan', 0)" min="0" max="9999" />
                    <x-input-form label="Stok Rusak Berat" nama="stok_rusak_berat" tipe="number" wajib :value="old('stok_rusak_berat', 0)" min="0" max="9999" />
                </div>

                <x-input-form label="Deskripsi" nama="deskripsi" tipe="textarea" placeholder="Deskripsi singkat alat..." />

                <div class="flex gap-3 justify-end mt-2">
                    <x-tombol varian="sekunder" :href="route('admin.alat.indeks')">Batal</x-tombol>
                    <x-tombol tipe="submit">Simpan Alat</x-tombol>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
