<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AjukanPeminjamanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isMahasiswa();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'alat_id'                 => ['required', 'integer', 'exists:alats,id'],
            'jumlah'                  => ['required', 'integer', 'min:1'],
            'tanggal_pinjam'          => ['required', 'date', 'after:today'],
            'tanggal_rencana_kembali' => ['required', 'date', 'after:tanggal_pinjam'],
        ];
    }

    public function messages(): array
    {
        return [
            'alat_id.required'                 => 'Alat wajib dipilih.',
            'alat_id.exists'                   => 'Alat yang dipilih tidak ditemukan.',
            'jumlah.required'                  => 'Jumlah wajib diisi.',
            'jumlah.min'                        => 'Jumlah minimal 1 unit.',
            'tanggal_pinjam.required'          => 'Tanggal pinjam wajib diisi.',
            'tanggal_pinjam.after'             => 'Tanggal pinjam harus setelah hari ini.',
            'tanggal_rencana_kembali.required' => 'Tanggal rencana kembali wajib diisi.',
            'tanggal_rencana_kembali.after'    => 'Tanggal rencana kembali harus setelah tanggal pinjam.',
        ];
    }
}
