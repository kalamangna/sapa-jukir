<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses login pengguna.
     */
    public function login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CEK LOGIN
        |--------------------------------------------------------------------------
        |
        | Hanya akun dengan status aktif yang dapat login.
        |
        */

        $credentials['status'] = 'aktif';


        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            /*
            |--------------------------------------------------------------------------
            | REGENERATE SESSION
            |--------------------------------------------------------------------------
            */

            $request->session()->regenerate();


            /*
            |--------------------------------------------------------------------------
            | REDIRECT BERDASARKAN ROLE
            |--------------------------------------------------------------------------
            */

            $user = Auth::user();

            if ($user->role === 'admin') {

                return redirect()
                    ->route('admin.dashboard');

            }


            if ($user->role === 'operator') {

                return redirect()
                    ->route('admin.dashboard');

            }


            if ($user->role === 'pimpinan') {

                return redirect()
                    ->route('admin.laporan.index');

            }


            /*
            |--------------------------------------------------------------------------
            | ROLE TIDAK DIKENAL
            |--------------------------------------------------------------------------
            */

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'email' => 'Role akun tidak dikenali.',
                ])
                ->onlyInput('email');
        }


        /*
        |--------------------------------------------------------------------------
        | LOGIN GAGAL
        |--------------------------------------------------------------------------
        */

        return back()
            ->withErrors([
                'email' => 'Email atau password tidak sesuai, atau akun tidak aktif.',
            ])
            ->onlyInput('email');
    }


    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with(
                'success',
                'Anda berhasil keluar dari sistem.'
            );
    }
}