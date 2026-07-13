<x-app>
    <x-slot name="navbar">
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-14">

                    <span class="font-bold text-gray-800 text-lg">SIPLAB</span>

                    <div class="hidden sm:flex gap-6 text-sm font-medium">
                        <a href="{{ route('mahasiswa.katalog') }}"
                           class="{{ request()->routeIs('mahasiswa.katalog*') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                            Katalog Alat
                        </a>
                        <a href="{{ route('mahasiswa.riwayat') }}"
                           class="{{ request()->routeIs('mahasiswa.riwayat*') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                            Riwayat Pinjam
                        </a>
                    </div>

                    <div class="flex items-center gap-3 text-sm">
                        <span class="text-gray-600">{{ Auth::user()->nama }}</span>
                        <span class="text-gray-400 text-xs">NIM: {{ Auth::user()->nim }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </x-slot>

    {{ $slot }}
</x-app>