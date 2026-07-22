<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EditAlatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isAdmin();
    }

    public function rules(): array
    {
        $alatId = $this->route('alat'); // dapat ID dari route parameter

        return [
            'nama_alat'  => ['required', 'string', 'max:150'],
            'kode_barang' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                // Unique kecuali untuk alat yang sedang diedit
                Rule::unique('alats', 'kode_barang')->ignore($alatId),
            ],
            'deskripsi'  => ['nullable', 'string', 'max:1000'],
            'stok_baik'         => ['required', 'integer', 'min:0', 'max:9999'],
            'stok_rusak_ringan' => ['required', 'integer', 'min:0', 'max:9999'],
            'stok_rusak_berat'  => ['required', 'integer', 'min:0', 'max:9999'],
            'gambar'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_barang.unique' => 'Kode barang sudah digunakan oleh alat lain.',
        ];
    }

    // Validasi tambahan: total gabungan minimal 1, dan stok_baik tidak boleh < stok_tersedia saat ini
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $alat = $this->route('alat');
            $total = (int) $this->stok_baik + (int) $this->stok_rusak_ringan + (int) $this->stok_rusak_berat;

            if ($total < 1) {
                $validator->errors()->add(
                    'stok_baik',
                    'Total stok (gabungan semua kondisi) minimal 1 unit.'
                );
            }

            if ($alat && $this->stok_baik < $alat->stok_tersedia) {
                $validator->errors()->add(
                    'stok_baik',
                    "Stok kondisi baik tidak boleh lebih kecil dari stok yang sedang tersedia dipinjam ({$alat->stok_tersedia})."
                );
            }
        });
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'kode_barang' => strtoupper(trim($this->kode_barang ?? '')),
        ]);
    }
}