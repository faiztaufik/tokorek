<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralLoginController extends Controller
{
    public function index()
    {
        return view('general.pages.login.index', [
            'title' => 'Login',
        ]);
    }

    public function login(Request $request)
    {
        try {
            // Validasi input
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            // Coba autentikasi
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->route('general.home')->with('success', 'Berhasil login.');
            }

            // Jika gagal login
            return back()->withErrors([
                'email' => 'Email atau kata sandi salah.',
            ])->withInput($request->only('email'));
        } catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat mencoba login. Silakan coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('general.home'); // Ganti sesuai route login
    }
}
