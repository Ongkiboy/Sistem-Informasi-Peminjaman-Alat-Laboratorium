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
            'stok_baik'         => ['required', 'integer', 'min:0', 'max:9999'],
            'stok_rusak_ringan' => ['required', 'integer', 'min:0', 'max:9999'],
            'stok_rusak_berat'  => ['required', 'integer', 'min:0', 'max:9999'],
            'gambar'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_alat.required'    => 'Nama alat wajib diisi.',
            'kode_barang.required'  => 'Kode barang wajib diisi.',
            'kode_barang.unique'    => 'Kode barang sudah digunakan.',
            'kode_barang.alpha_dash'=> 'Kode barang hanya boleh berisi huruf, angka, dan tanda hubung.',
            'stok_baik.required'         => 'Stok kondisi baik wajib diisi (boleh 0).',
            'stok_rusak_ringan.required' => 'Stok kondisi rusak ringan wajib diisi (boleh 0).',
            'stok_rusak_berat.required'  => 'Stok kondisi rusak berat wajib diisi (boleh 0).',
        ];
    }

    // Validasi tambahan: total gabungan ketiga kondisi minimal 1 unit
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $total = (int) $this->stok_baik + (int) $this->stok_rusak_ringan + (int) $this->stok_rusak_berat;

            if ($total < 1) {
                $validator->errors()->add(
                    'stok_baik',
                    'Total stok (gabungan semua kondisi) minimal 1 unit.'
                );
            }
        });
    }

    // Transformasi input sebelum validasi (uppercase kode_barang)
    protected function prepareForValidation(): void
    {
        $this->merge([
            'kode_barang' => strtoupper(trim($this->kode_barang ?? '')),
        ]);
    }
}