<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApprovalController extends Controller
{
    public function __construct(
        private readonly PeminjamanService $peminjamanService
    ) {}

    /**
     * Daftar semua pengajuan dengan filter status.
     * Default: pending, pagination 15.
     */
    public function indeks(Request $request): View
    {
        $statusFilter = $request->get('status', 'pending');
        $statusValid  = ['semua', 'pending', 'approved', 'borrowed', 'returned', 'rejected'];

        if (!in_array($statusFilter, $statusValid)) {
            $statusFilter = 'pending';
        }

        $peminjaman = Peminjaman::with(['pengguna', 'alat'])
            ->when($statusFilter !== 'semua', function ($query) use ($statusFilter) {
                $query->where('status', $statusFilter);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Jumlah per status untuk badge di tab filter — 1 query, bukan 5
        $jumlahMentah = Peminjaman::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $jumlahPerStatus = [
            'pending'  => $jumlahMentah['pending'] ?? 0,
            'approved' => $jumlahMentah['approved'] ?? 0,
            'borrowed' => $jumlahMentah['borrowed'] ?? 0,
            'returned' => $jumlahMentah['returned'] ?? 0,
            'rejected' => $jumlahMentah['rejected'] ?? 0,
        ];

        return view('admin.approval.indeks', compact('peminjaman', 'statusFilter', 'jumlahPerStatus'));
    }

    /**
     * Setujui pengajuan: pending → approved.
     * Stok tidak berubah (sudah dikurangi saat pengajuan).
     */
    public function setujui(Peminjaman $peminjaman): RedirectResponse
    {
        try {
            $this->peminjamanService->setujuiPeminjaman($peminjaman);
        } catch (\Exception $e) {
            return redirect()->route('admin.approval.indeks')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.approval.indeks')
            ->with('success', 'Pengajuan berhasil disetujui.');
    }

    /**
     * Tolak pengajuan: pending → rejected.
     * Stok dikembalikan oleh PeminjamanService.
     */
    public function tolak(Peminjaman $peminjaman): RedirectResponse
    {
        try {
            $this->peminjamanService->tolakPeminjaman($peminjaman);
        } catch (\Exception $e) {
            return redirect()->route('admin.approval.indeks')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.approval.indeks')
            ->with('success', 'Pengajuan ditolak dan stok dikembalikan.');
    }

    /**
     * Konfirmasi alat sudah diambil: approved → borrowed.
     */
    public function diambil(Peminjaman $peminjaman): RedirectResponse
    {
        try {
            $this->peminjamanService->konfirmasiDiambil($peminjaman);
        } catch (\Exception $e) {
            return redirect()->route('admin.approval.indeks')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.approval.indeks')
            ->with('success', 'Status diperbarui: alat sudah diambil mahasiswa.');
    }

    /**
     * Konfirmasi alat sudah dikembalikan: borrowed → returned.
     * Stok dipulihkan oleh PeminjamanService.
     */
    public function kembali(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        $request->validate([
            'kondisi_kembali' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
        ]);

        try {
            $this->peminjamanService->konfirmasiPengembalian($peminjaman, $request->kondisi_kembali);
        } catch (\Exception $e) {
            return redirect()->route('admin.approval.indeks')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.approval.indeks')
            ->with('success', 'Alat berhasil dikembalikan.');
    }
}