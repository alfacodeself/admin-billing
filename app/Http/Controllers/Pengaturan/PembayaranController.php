<?php

namespace App\Http\Controllers\Pengaturan;

use Illuminate\Http\Request;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\DB;
use App\Models\PengaturanBagiHasil;
use App\Http\Controllers\Controller;

class PembayaranController extends Controller
{
    public function index()
    {
        $metode_pembayaran = MetodePembayaran::get();
        $bagi_hasil = PengaturanBagiHasil::get();
        $general = DB::table('pengaturan_pembayaran')->first();
        return view('app.pengaturan.pembayaran', compact('metode_pembayaran', 'bagi_hasil', 'general'));
    }
}
