<x-mahasiswa-layout>
    <x-slot name="title">Ajukan Peminjaman</x-slot>

    <div class="max-w-xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('mahasiswa.katalog') }}" class="text-gray-400 hover:text-gray-600 text-sm transition-colors duration-150">
                ← Kembali ke Katalog
            </a>
            <h1 class="text-xl font-bold text-gray-900">Ajukan Peminjaman</h1>
        </div>

        {{-- Info Alat --}}
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6">
            <p class="text-xs text-blue-400 font-mono mb-1">{{ $alat->kode_barang }}</p>
            <h2 class="font-bold text-blue-800 text-base mb-2">{{ $alat->nama_alat }}</h2>
            <div class="flex gap-4 text-sm">
                <span class="text-blue-600">Stok tersedia: <strong>{{ $alat->stok_tersedia }}</strong></span>
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

                <x-input-form
                    label="Jumlah Unit"
                    nama="jumlah"
                    tipe="number"
                    wajib
                    :value="old('jumlah', 1)"
                    min="1"
                    :max="$alat->stok_tersedia"
                    :bantuan="'Maksimal '.$alat->stok_tersedia.' unit.'" />

                <x-input-form
                    label="Tanggal Mulai Pinjam"
                    nama="tanggal_pinjam"
                    tipe="date"
                    wajib
                    :value="old('tanggal_pinjam')"
                    :min="now()->addDay()->format('Y-m-d')"
                    :bantuan="'Minimal besok ('.now()->addDay()->format('d M Y').').'" />

                <x-input-form
                    label="Tanggal Rencana Kembali"
                    nama="tanggal_rencana_kembali"
                    tipe="date"
                    wajib
                    :value="old('tanggal_rencana_kembali')"
                    id="inputTanggalKembali"
                    bantuan="Harus setelah tanggal mulai pinjam." />

                <x-tombol tipe="submit" id="btnSubmit" class="w-full mt-2" ukuran="lg">
                    Kirim Pengajuan
                </x-tombol>
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
                }
            }
        });

        // Loading state saat form submit
        document.getElementById('formPeminjaman').addEventListener('submit', function () {
            const btn = document.getElementById('btnSubmit');
            btn.disabled = true;
            btn.textContent = 'Mengirim...';
        });
    </script>
    @endpush

</x-mahasiswa-layout>
