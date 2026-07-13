<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class cekMahasiswa
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()){
            return redirect()->route('login')
            ->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (!Auth::user()->isMahasiswa()){
            abourt(403, 'Akses ditolak. Halaman ini hanya dapat diakses oleh mahasiswa.');
        }
        return $next($request);
    }
}
