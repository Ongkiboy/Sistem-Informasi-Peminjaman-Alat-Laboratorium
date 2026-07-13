<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function tampilkanLogin(): View|RedirectResponse
    {
        if(Auth::check()){
            return $this->redirectBerdasarkanRole();
        }
        return view('auth.login');
    }


    public function prosesLogin(LoginRequest $request) :RedirectResponse 
    {
        $kredensial = $request->only('email','password');

        if(Auth::attempt($kredensial, $request->boolean('ingat_saya'))){
            $request->session()->regenerate();
            return $this->redirectBerdasarkanRole();
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password salah.'
            ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::Logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    
    private function redirectBerdasarkanRole(): RedirectResponse
    {
        return Auth::user()->is_admin ?
            redirect()->route('admin.dashboard'):
            redirect()->route('mahasiswa.katalog');
    }
}
