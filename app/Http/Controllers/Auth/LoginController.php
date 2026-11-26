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
            'username' => [
                'required',
                'string',
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
                    'username' => 'Role akun tidak dikenali.',
                ])
                ->onlyInput('username');
        }


        /*
        |--------------------------------------------------------------------------
        | LOGIN GAGAL
        |--------------------------------------------------------------------------
        */

        return back()
            ->withErrors([
                'username' => 'Username atau password tidak sesuai, atau akun tidak aktif.',
            ])
            ->onlyInput('username');
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