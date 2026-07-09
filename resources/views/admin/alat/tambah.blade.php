<x-admin-layout>
    <x-slot name="title">Tambah Alat</x-slot>

    <div class="max-w-2xl">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.alat.indeks') }}" class="text-gray-400 hover:text-gray-600 text-sm">
                ← Kembali
            </a>
            <h1 class="text-xl font-bold text-gray-800">Tambah Alat Baru</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('admin.alat.simpan') }}">
                @csrf

                {{-- Nama Alat --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Alat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_alat" value="{{ old('nama_alat') }}"
                           class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                  {{ $errors->has('nama_alat') ? 'border-red-400' : 'border-gray-300' }}"
                           placeholder="cth: Mikroskop Binokuler">
                    @error('nama_alat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kode Barang --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kode Barang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="kode_barang" value="{{ old('kode_barang') }}"
                           class="w-full border rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500
                                  {{ $errors->has('kode_barang') ? 'border-red-400' : 'border-gray-300' }}"
                           placeholder="cth: MKR-001">
                    <p class="text-gray-400 text-xs mt-1">Otomatis diubah ke huruf kapital. Hanya huruf, angka, dan tanda hubung.</p>
                    @error('kode_barang')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kondisi dan Total Stok (2 kolom) --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kondisi <span class="text-red-500">*</span>
                        </label>
                        <select name="kondisi"
                                class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                       {{ $errors->has('kondisi') ? 'border-red-400' : 'border-gray-300' }}">
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="baik"{{ old('kondisi')==='baik'?'selected' :''}}>Baik</option>
                            <option value="rusak_ringan"{{ old('kondisi')==='rusak_ringan'?'selected' :''}}>Rusak Ringan</option>
                            <option value="rusak_berat"{{ old('kondisi')==='rusak_berat'?'selected' :''}}>Rusak Berat</option>
                        </select>
                        @error('kondisi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Total Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="total_stok" value="{{ old('total_stok', 1) }}"
                               min="1" max="9999"
                               class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                      {{ $errors->has('total_stok') ? 'border-red-400' : 'border-gray-300' }}">
                        @error('total_stok')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi <span class="text-gray-400 text-xs font-normal">(opsional)</span>
                    </label>
                    <textarea name="deskripsi" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Deskripsi singkat alat...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 justify-end">
                    <a href="{{ route('admin.alat.indeks') }}"
                       class="text-sm px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition text-gray-700">
                        Batal
                    </a>
                    <button type="submit"
                            class="text-sm px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition">
                        Simpan Alat
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>