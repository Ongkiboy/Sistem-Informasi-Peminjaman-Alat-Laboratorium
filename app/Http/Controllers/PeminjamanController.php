<?php

namespace App\Http\Controllers;

use App\Exceptions\StokTidakCukupException;
use App\Http\Requests\AjukanPeminjamanRequest;
use App\Models\Alat;
use App\Services\PeminjamanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function __construct(
        private readonly PeminjamanService $peminjamanService
    ) {}

    public function tampilkanForm(Alat $alat): View|RedirectResponse
    {
        if ($alat->stok_tersedia <= 0) {
            return redirect()->route('mahasiswa.katalog')
                ->with('error', 'Stok alat ini sedang habis.');
        }

        return view('mahasiswa.peminjaman.form', compact('alat'));
    }

    public function ajukan(AjukanPeminjamanRequest $request): RedirectResponse
    {
        try {
            $this->peminjamanService->ajukanPeminjaman($request->validated(), Auth::id());

            return redirect()->route('mahasiswa.riwayat')
                ->with('success', 'Pengajuan peminjaman berhasil dikirim, menunggu persetujuan admin.');
        } catch (StokTidakCukupException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
