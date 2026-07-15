<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function indeks(): View
    {
        // Cache statistik 5 menit untuk performa (FR-DASHBOARD-001)
        $statistik = Cache::remember('dashboard_statistik', 300, function () {
            return [
                'total_alat'       => Alat::count(),
                'peminjaman_aktif' => Peminjaman::whereIn('status', ['approved', 'borrowed'])->count(),
                'pending_hari_ini' => Peminjaman::where('status', 'pending')
                                        ->whereDate('created_at', today())
                                        ->count(),
                'total_bulan_ini'  => Peminjaman::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
            ];
        });

        // 10 pengajuan terbaru — tidak di-cache (harus selalu fresh)
        $pengajuanTerbaru = Peminjaman::with(['pengguna', 'alat'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('statistik', 'pengajuanTerbaru'));
    }
}