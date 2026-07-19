@props(['title' => null])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title . ' — Admin — SIPLAB' : 'Admin — SIPLAB' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">

<div x-data="{ sidebarBuka: false }" class="flex min-h-screen">

    {{-- Overlay mobile --}}
    <div x-show="sidebarBuka" @click="sidebarBuka = false" x-cloak
         x-transition.opacity
         class="fixed inset-0 bg-black/40 z-20 lg:hidden"></div>

    {{-- Sidebar --}}
    <aside :class="sidebarBuka ? 'translate-x-0' : '-translate-x-full'"
           class="fixed lg:static lg:translate-x-0 inset-y-0 left-0 z-30
                  w-60 bg-white border-r border-gray-100 flex flex-col
                  transition-transform duration-200 ease-in-out">

        {{-- Logo --}}
        <div class="px-5 py-5 border-b border-gray-100">
            <div class="text-xl font-bold text-blue-600">🔬 SIPLAB</div>
            <div class="text-[10px] font-semibold text-blue-400 uppercase tracking-widest mt-0.5">Admin Panel</div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 p-3 space-y-0.5">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard', 'icon' => '📊', 'label' => 'Dashboard'],
                    ['route' => 'admin.alat.indeks', 'icon' => '📦', 'label' => 'Kelola Alat'],
                    ['route' => 'admin.approval.indeks', 'icon' => '📋', 'label' => 'Pengajuan'],
                ];
                $pendingCount = \App\Models\Peminjaman::where('status', 'pending')->count();
            @endphp

            @foreach($navItems as $item)
                @php $aktif = request()->routeIs($item['route'].'*'); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                          {{ $aktif ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                    <span class="text-base">{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>

                    @if($item['route'] === 'admin.approval.indeks' && $pendingCount > 0)
                        <span class="ml-auto text-[10px] font-bold bg-red-500 text-white px-1.5 py-0.5 rounded-full">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            @endforeach
        </nav>

        {{-- User footer --}}
        <div class="p-3 border-t border-gray-100">
            <div class="px-3 py-2 mb-1">
                <p class="text-xs font-semibold text-gray-900 truncate">{{ Auth::user()->nama }}</p>
                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors duration-150">
                    <span>🚪</span> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main area --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Topbar mobile --}}
        <header class="lg:hidden bg-white border-b border-gray-100 px-4 py-3 flex items-center gap-3 sticky top-0 z-20">
            <button @click="sidebarBuka = true" class="p-1.5 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="text-lg font-bold text-blue-600">🔬 SIPLAB</span>
        </header>

        <main class="flex-1 p-4 sm:p-6">
            <x-pesan-flash />
            {{ $slot }}
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
