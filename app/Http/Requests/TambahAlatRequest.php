<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TambahAlatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nama_alat'   => ['required', 'string', 'max:150'],
            'kode_barang' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:alats,kode_barang'],
            'deskripsi'   => ['nullable', 'string', 'max:1000'],
            'kondisi'     => ['required', 'in:baik,rusak_ringan,rusak_berat'],
            'total_stok'  => ['required', 'integer', 'min:1', 'max:9999'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_alat.required'    => 'Nama alat wajib diisi.',
            'kode_barang.required'  => 'Kode barang wajib diisi.',
            'kode_barang.unique'    => 'Kode barang sudah digunakan.',
            'kode_barang.alpha_dash'=> 'Kode barang hanya boleh berisi huruf, angka, dan tanda hubung.',
            'kondisi.required'      => 'Kondisi alat wajib dipilih.',
            'kondisi.in'            => 'Kondisi alat tidak valid.',
            'total_stok.required'   => 'Total stok wajib diisi.',
            'total_stok.min'        => 'Total stok minimal 1.',
            'total_stok.integer'    => 'Total stok harus berupa angka bulat.',
        ];
    }

    // Transformasi input sebelum validasi (uppercase kode_barang)
    protected function prepareForValidation(): void
    {
        $this->merge([
            'kode_barang' => strtoupper(trim($this->kode_barang ?? '')),
        ]);
    }
}