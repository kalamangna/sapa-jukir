<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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
                'max:50',
            ],

            'password' => [
                'required',
                'string',
                'max:128',
            ],
        ]);

        $throttleKey = 'login:' . Str::lower(trim($credentials['username'])) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            Log::warning('Login diblokir sementara karena terlalu banyak percobaan gagal.', [
                'username' => $credentials['username'],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'retry_after_seconds' => $seconds,
            ]);

            return back()
                ->withErrors([
                    'username' => "Terlalu banyak percobaan login gagal. Coba lagi dalam {$seconds} detik.",
                ])
                ->onlyInput('username');
        }


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
            RateLimiter::clear($throttleKey);

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

        RateLimiter::hit($throttleKey, 60);

        Log::warning('Percobaan login gagal.', [
            'username' => $credentials['username'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

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