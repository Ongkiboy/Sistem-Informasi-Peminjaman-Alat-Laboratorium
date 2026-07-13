<x-app>
    <x-slot name="navbar">
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-14">

                    {{-- Brand --}}
                    <span class="font-bold text-gray-800 text-lg">SIPLAB</span>

                    {{-- Nav Links --}}
                    <div class="hidden sm:flex gap-6 text-sm font-medium">
                        <a href="{{ route('admin.dashboard') }}"
                           class="{{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.alat.indeks') }}"
                           class="{{ request()->routeIs('admin.alat.*') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                            Data Alat
                        </a>
                        <a href="{{ route('admin.approval.indeks') }}"
                           class="{{ request()->routeIs('admin.approval.*') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                            Pengajuan
                        </a>
                    </div>

                    {{-- User + Logout --}}
                    <div class="flex items-center gap-3 text-sm">
                        <span class="text-gray-600">{{ Auth::user()->nama }}</span>
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