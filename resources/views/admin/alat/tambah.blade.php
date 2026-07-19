<x-admin-layout>
    <x-slot name="title">Tambah Alat</x-slot>

    <div class="max-w-2xl">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.alat.indeks') }}" class="text-gray-400 hover:text-gray-600 text-sm transition-colors duration-150">
                ← Kembali
            </a>
            <h1 class="text-xl font-bold text-gray-900">Tambah Alat Baru</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('admin.alat.simpan') }}">
                @csrf

                <x-input-form label="Nama Alat" nama="nama_alat" wajib placeholder="cth: Mikroskop Binokuler" />

                <x-input-form
                    label="Kode Barang"
                    nama="kode_barang"
                    wajib
                    class="font-mono"
                    placeholder="cth: MKR-001"
                    bantuan="Otomatis diubah ke huruf kapital. Hanya huruf, angka, dan tanda hubung." />

                {{-- Kondisi dan Total Stok (2 kolom) --}}
                <div class="grid grid-cols-2 gap-4">
                    <x-input-form label="Kondisi" nama="kondisi" tipe="select" wajib>
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="baik" @selected(old('kondisi') === 'baik')>Baik</option>
                        <option value="rusak_ringan" @selected(old('kondisi') === 'rusak_ringan')>Rusak Ringan</option>
                        <option value="rusak_berat" @selected(old('kondisi') === 'rusak_berat')>Rusak Berat</option>
                    </x-input-form>

                    <x-input-form label="Total Stok" nama="total_stok" tipe="number" wajib :value="old('total_stok', 1)" min="1" max="9999" />
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
