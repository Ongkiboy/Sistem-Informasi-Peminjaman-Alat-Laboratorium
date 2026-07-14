<x-mahasiswa-layout>
    <x-slot name="title">Ajukan Peminjaman</x-slot>

    <div class="max-w-xl">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('mahasiswa.katalog') }}" class="text-gray-400 hover:text-gray-600 text-sm">
                ← Kembali ke Katalog
            </a>
            <h1 class="text-xl font-bold text-gray-800">Ajukan Peminjaman</h1>
        </div>

        {{-- Info Alat --}}
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6">
            <p class="text-xs text-blue-400 font-mono mb-1">{{ $alat->kode_barang }}</p>
            <h2 class="font-bold text-blue-800 text-base mb-2">{{ $alat->nama_alat }}</h2>
            <div class="flex gap-4 text-sm">
                <span class="text-blue-600">Stok tersedia: <strong>{{ $alat->stok_tersedia }}</strong></span>
                <span class="text-blue-600">Kondisi: <strong>{{ ucwords(str_replace('_', ' ', $alat->kondisi)) }}</strong></span>
            </div>
            @if($alat->deskripsi)
                <p class="text-xs text-blue-500 mt-2">{{ $alat->deskripsi }}</p>
            @endif
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('mahasiswa.peminjaman.ajukan') }}" id="formPeminjaman">
                @csrf
                <input type="hidden" name="alat_id" value="{{ $alat->id }}">

                {{-- Jumlah --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Jumlah Unit <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="jumlah"
                        value="{{ old('jumlah', 1) }}"
                        min="1"
                        max="{{ $alat->stok_tersedia }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('jumlah') ? 'border-red-400' : 'border-gray-300' }}"
>
                    <p class="text-gray-400 text-xs mt-1">Maksimal {{ $alat->stok_tersedia }} unit.</p>
                    @error('jumlah')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Pinjam --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Mulai Pinjam <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        name="tanggal_pinjam"
                        value="{{ old('tanggal_pinjam') }}"
                        min="{{ now()->addDay()->format('Y-m-d') }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('tanggal_pinjam') ? 'border-red-400' : 'border-gray-300' }}"
>
                    <p class="text-gray-400 text-xs mt-1">Minimal besok ({{ now()->addDay()->format('d M Y') }}).</p>
                    @error('tanggal_pinjam')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Rencana Kembali --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Rencana Kembali <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        name="tanggal_rencana_kembali"
                        value="{{ old('tanggal_rencana_kembali') }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                               {{ $errors->has('tanggal_rencana_kembali') ? 'border-red-400' : 'border-gray-300' }}"
                        id="inputTanggalKembali"
>
                    <p class="text-gray-400 text-xs mt-1">Harus setelah tanggal mulai pinjam.</p>
                    @error('tanggal_rencana_kembali')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    id="btnSubmit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg text-sm transition"
>
                    Kirim Pengajuan
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Update min date tanggal kembali saat tanggal pinjam berubah
        const inputPinjam = document.querySelector('[name="tanggal_pinjam"]');
        const inputKembali = document.getElementById('inputTanggalKembali');

        inputPinjam.addEventListener('change', function () {
            if (this.value) {
                // Min tanggal kembali = tanggal pinjam + 1 hari
                const tglPinjam = new Date(this.value);
                tglPinjam.setDate(tglPinjam.getDate() + 1);
                inputKembali.min = tglPinjam.toISOString().split('T')[0];

                // Reset nilai tanggal kembali jika sudah tidak valid
                if (inputKembali.value && inputKembali.value <= this.value) {
                    inputKembali.value = '';

                    // Loading state saat form submit
document.getElementById('formPeminjaman').addEventListener('submit', function () {
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.textContent = 'Mengirim...';
    btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
    btn.classList.add('bg-blue-400', 'cursor-not-allowed');
});
                }
            }
        });
    </script>
    @endpush

</x-mahasiswa-layout>