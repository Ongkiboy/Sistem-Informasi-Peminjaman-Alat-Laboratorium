@php
    $peta = [
        'success' => ['bg-green-50 border-green-200 text-green-800', 'check-circle'],
        'error'   => ['bg-red-50 border-red-200 text-red-800', 'exclamation-triangle'],
        'info'    => ['bg-blue-50 border-blue-200 text-blue-800', 'info-circle'],
    ];
    $durasi = ['success' => 4000, 'error' => 5000, 'info' => 3000];
@endphp

@foreach(['success', 'error', 'info'] as $tipe)
    @if(session($tipe))
        @php [$kelas, $ikon] = $peta[$tipe]; @endphp
        <div x-data="{ tampil: true }"
             x-show="tampil"
             x-init="setTimeout(() => tampil = false, {{ $durasi[$tipe] }})"
             x-transition
             class="mb-4 p-4 border rounded-lg flex items-center justify-between {{ $kelas }}">
            <span class="flex items-center gap-2">
                <x-ikon :nama="$ikon" ukuran="sm" class="flex-shrink-0" />
                <span>{{ session($tipe) }}</span>
            </span>
            <button @click="tampil = false" aria-label="Tutup notifikasi" class="opacity-60 hover:opacity-100 transition-opacity">
                <x-ikon nama="x-mark" ukuran="sm" />
            </button>
        </div>
    @endif
@endforeach
