<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->verifikasi_email == null) {
            Auth::logout();
            return redirect()->route('login')->with([
                'danger' => 'Harap verifikasi email anda terlebih dahulu!', 
                'verify' => true
            ]);
        }
        return $next($request);
    }
}
