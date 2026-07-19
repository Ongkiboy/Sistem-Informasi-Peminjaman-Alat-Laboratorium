@props(['status'])

@php
    $peta = [
        'pending'   => ['kelas' => 'bg-yellow-100 text-yellow-800', 'dot' => 'bg-yellow-500 animate-pulse', 'label' => 'Menunggu'],
        'approved'  => ['kelas' => 'bg-blue-100 text-blue-800',     'dot' => 'bg-blue-500',                 'label' => 'Disetujui'],
        'borrowed'  => ['kelas' => 'bg-purple-100 text-purple-800', 'dot' => 'bg-purple-500',               'label' => 'Dipinjam'],
        'returned'  => ['kelas' => 'bg-green-100 text-green-800',   'dot' => 'bg-green-500',                'label' => 'Dikembalikan'],
        'rejected'  => ['kelas' => 'bg-red-100 text-red-800',       'dot' => 'bg-red-400',                  'label' => 'Ditolak'],
    ];
    $config = $peta[$status] ?? ['kelas' => 'bg-gray-100 text-gray-800', 'dot' => 'bg-gray-400', 'label' => $status];
@endphp

<span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full whitespace-nowrap {{ $config['kelas'] }}">
    <span class="h-1.5 w-1.5 rounded-full flex-shrink-0 {{ $config['dot'] }}"></span>
    {{ $config['label'] }}
</span>
