<?php

namespace App\Http\Middleware;

use App\Models\JenisDokumen;
use App\Models\Pelanggan;
use Closure;
use Illuminate\Http\Request;

class CompleteDocument
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, Pelanggan $pelanggan)
    {
        $syarat_dokumen = JenisDokumen::where('status', 'a')->where('status_dokumen', 'm')->get()->count();
        if ($pelanggan->dokumen_pelanggan->count() != $syarat_dokumen) {
            return redirect()->back()->with('danger', 'Dokumen anda belum lengkap');
        }
        return $next($request);
    }
}
