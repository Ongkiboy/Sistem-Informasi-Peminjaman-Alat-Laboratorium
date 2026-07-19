<?php

namespace App\Http\Requests;

use App\Models\Alat;
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
            'kondisi'    => ['required', 'in:baik,rusak_ringan,rusak_berat'],
            'total_stok' => ['required', 'integer', 'min:1', 'max:9999'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_barang.unique' => 'Kode barang sudah digunakan oleh alat lain.',
            'total_stok.min'     => 'Total stok minimal 1.',
        ];
    }

    // Validasi tambahan: total_stok baru tidak boleh < stok_tersedia saat ini
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $alatId = $this->route('alat');
            $alat = Alat::find($alatId);

            if ($alat && $this->total_stok < $alat->stok_tersedia) {
                $validator->errors()->add(
                    'total_stok',
                    "Total stok tidak boleh lebih kecil dari stok yang sedang tersedia ({$alat->stok_tersedia})."
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