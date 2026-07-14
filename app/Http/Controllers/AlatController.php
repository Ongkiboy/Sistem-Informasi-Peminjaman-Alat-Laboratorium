<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditAlatRequest;
use App\Http\Requests\TambahAlatRequest;
use App\Models\Alat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AlatController extends Controller
{
    public function indeks(Request $request): View
    {
        $alat = Alat::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('nama_alat', 'like', "%{$request->q}%")
                      ->orWhere('kode_barang', 'like', "%{$request->q}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString(); // pertahankan ?q= saat pindah halaman

        return view('admin.alat.indeks', compact('alat'));
    }

    public function tampilkanForm(): View
    {
        return view('admin.alat.tambah');
    }

    public function simpan(TambahAlatRequest $request): RedirectResponse
    {
        Alat::create([
            ...$request->validated(),
            'stok_tersedia' => $request->total_stok, // otomatis = total_stok saat pertama buat
            'dibuat_oleh'   => Auth::id(),
        ]);

        return redirect()->route('admin.alat.indeks')
            ->with('success', 'Alat berhasil ditambahkan.');
    }

    public function tampilkanEdit(Alat $alat): View
    {
        return view('admin.alat.edit', compact('alat'));
    }

    public function perbarui(EditAlatRequest $request, Alat $alat): RedirectResponse
    {
        $alat->update($request->validated());

        return redirect()->route('admin.alat.indeks')
            ->with('success', 'Data alat berhasil diperbarui.');
    }

    public function hapus(Alat $alat): RedirectResponse
    {
        // Cek peminjaman aktif sebelum hapus (dikerjain di BE-INVENT-004)
        if ($alat->memilikiPeminjamanAktif()) {
            return redirect()->route('admin.alat.indeks')
                ->with('error', 'Alat tidak bisa dihapus karena masih ada peminjaman aktif.');
        }

        $alat->delete(); // soft delete

        return redirect()->route('admin.alat.indeks')
            ->with('success', 'Alat berhasil dihapus.');
    }
}