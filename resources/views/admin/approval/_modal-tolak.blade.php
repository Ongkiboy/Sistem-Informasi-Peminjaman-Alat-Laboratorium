<div id="modalTolak"
     class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-sm mx-4">
        <div class="flex items-start gap-3 mb-4">
            <span class="text-2xl">⚠️</span>
            <div>
                <h3 class="font-bold text-gray-800 mb-1">Tolak Pengajuan?</h3>
                <p class="text-sm text-gray-600">
                    Yakin ingin menolak pengajuan
                    <strong id="modalNamaMahasiswa"></strong>
                    untuk alat <strong id="modalNamaAlat"></strong>?
                </p>
                <p class="text-xs text-gray-400 mt-2">Stok akan dikembalikan otomatis.</p>
            </div>
        </div>

        <div class="flex gap-3 justify-end mt-5">
            <button
                onclick="tutupModalTolak()"
                class="text-sm px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                Batal
            </button>
            <form id="formTolak" method="POST">
                @csrf
                <button type="submit"
                        class="text-sm px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition">
                    Ya, Tolak
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function tampilkanModalTolak(id, namaAlat, namaMahasiswa) {
        document.getElementById('modalNamaAlat').textContent      = namaAlat;
        document.getElementById('modalNamaMahasiswa').textContent  = namaMahasiswa;
        document.getElementById('formTolak').action               = `/admin/approval/${id}/tolak`;
        document.getElementById('modalTolak').classList.remove('hidden');
    }

    function tutupModalTolak() {
        document.getElementById('modalTolak').classList.add('hidden');
    }

    // Tutup modal jika klik di luar area modal
    document.getElementById('modalTolak').addEventListener('click', function(e) {
        if (e.target === this) tutupModalTolak();
    });
</script>
@endpush