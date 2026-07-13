<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TokenApiController extends Controller
{
    public function buat(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $pengguna = Pengguna::where('email', $request->email)->first();

        if (!$pengguna || !Hash::check($request->password, $pengguna->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial tidak valid.'],
            ]);
        }

        // Hapus token lama, buat token baru
        $pengguna->tokens()->delete();
        $token = $pengguna->createToken('siplab-api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'tipe'  => 'Bearer',
        ]);
    }

    public function cabut(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'pesan' => 'Token berhasil dicabut.',
        ]);
    }
}