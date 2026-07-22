<x-app :title="$title ?? null">
    <x-slot name="navbar">
        <nav class="bg-white border-b border-gray-100 sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                <a href="{{ route('mahasiswa.katalog') }}" class="text-xl font-bold text-blue-600 flex items-center gap-1.5">
                    <x-ikon nama="beaker" ukuran="md" /> SIPLAB
                </a>

                <div class="flex items-center gap-1">
                    <a href="{{ route('mahasiswa.katalog') }}"
                       class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150
                              {{ request()->routeIs('mahasiswa.katalog*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        Katalog
                    </a>
                    <a href="{{ route('mahasiswa.riwayat') }}"
                       class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-150
                              {{ request()->routeIs('mahasiswa.riwayat*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        Riwayat Saya
                    </a>

                    {{-- Avatar dropdown --}}
                    <div x-data="{ buka: false }" class="relative ml-2">
                        <button @click="buka = !buka"
                                class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                            <div class="h-7 w-7 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                            </div>
                            <span class="text-sm text-gray-700 hidden md:block">{{ Auth::user()->nama }}</span>
                            <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="buka" @click.outside="buka = false" x-cloak x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                            <div class="px-3 py-2 border-b border-gray-100">
                                <p class="text-xs font-semibold text-gray-900">{{ Auth::user()->nama }}</p>
                                <p class="text-xs text-gray-500">NIM: {{ Auth::user()->nim }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </x-slot>

    {{ $slot }}
</x-app>
