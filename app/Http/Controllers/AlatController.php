<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditAlatRequest;
use App\Http\Requests\TambahAlatRequest;
use App\Models\Alat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $data = $request->validated();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('alat', 'public');
        }
        Alat::create([
            ...$data,
            'stok_tersedia' => $data['stok_baik'], // otomatis = stok_baik saat pertama buat (cuma unit baik yang bisa dipinjam)
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
        $data = collect($request->validated())
            ->except('gambar')
            ->toArray();
        if ($request->hasFile('gambar')){
            if ($alat->gambar) {
                Storage::disk('public')->delete($alat->gambar);
            }
            $data['gambar'] = $request->file('gambar')
                ->store('alat', 'public');
        }
        $alat->update($data);

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