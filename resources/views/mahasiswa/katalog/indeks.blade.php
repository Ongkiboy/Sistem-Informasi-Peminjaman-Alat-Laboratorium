<x-mahasiswa-layout>
    <x-slot name="title">Katalog Alat</x-slot>

    {{-- Hero --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 md:p-8 mb-6 text-white relative overflow-hidden">
        <div class="absolute -top-8 -right-8 h-40 w-40 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-8 right-24 h-24 w-24 rounded-full bg-white/5"></div>

        <div class="relative">
            <h1 class="text-2xl md:text-3xl font-bold">Halo, {{ Auth::user()->nama }} 👋</h1>
            <p class="text-blue-100 mt-1 text-sm">Mau pinjam alat apa hari ini?</p>

            <form method="GET" class="mt-5 relative max-w-lg">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">🔍</span>
                <input type="search"
                       name="q"
                       value="{{ request('q') }}"
                       placeholder="Cari nama atau kode alat..."
                       class="w-full bg-white/95 text-gray-900 rounded-xl px-5 py-3 pl-11
                              focus:ring-4 focus:ring-white/30 outline-none text-sm placeholder-gray-400 transition-all duration-200">
            </form>
            @if(request('q'))
                <p class="text-xs text-blue-100 mt-2">
                    Menampilkan hasil untuk "{{ request('q') }}" —
                    <a href="{{ route('mahasiswa.katalog') }}" class="underline hover:text-white">reset</a>
                </p>
            @endif
        </div>
    </div>

    {{-- Grid Katalog --}}
    @if($alat->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6">
            @foreach($alat as $item)
                <x-kartu-alat :alat="$item" />
            @endforeach
        </div>

        {{ $alat->links() }}

    @else
        @php
            $pesanKosong = request('q')
                ? "Tidak ada alat dengan kata kunci \"".request('q')."\". Coba kata kunci lain."
                : 'Hubungi laboran untuk informasi lebih lanjut.';
        @endphp
        <x-kondisi-kosong
            ikon="🔍"
            :judul="request('q') ? 'Tidak ditemukan' : 'Belum ada alat tersedia'"
            :pesan="$pesanKosong"
            :ctaLabel="request('q') ? 'Lihat semua alat' : null"
            :ctaHref="request('q') ? route('mahasiswa.katalog') : null" />
    @endif

</x-mahasiswa-layout>
