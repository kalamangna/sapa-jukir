<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Membatasi akses berdasarkan role user.
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | CEK LOGIN
        |--------------------------------------------------------------------------
        */

        if (! $request->user()) {

            return redirect()
                ->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | CEK STATUS AKUN
        |--------------------------------------------------------------------------
        */

        if (! $request->user()->isActive()) {

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Akun Anda tidak aktif.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CEK ROLE
        |--------------------------------------------------------------------------
        */

        if (
            ! empty($roles) &&
            ! in_array(
                $request->user()->role,
                $roles,
                true
            )
        ) {

            abort(
                403,
                'Anda tidak memiliki hak akses untuk halaman ini.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | LANJUTKAN REQUEST
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}