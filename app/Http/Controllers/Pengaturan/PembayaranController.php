<?php

namespace App\Http\Controllers\Pengaturan;

use Illuminate\Http\Request;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\DB;
use App\Models\PengaturanBagiHasil;
use App\Http\Controllers\Controller;
use App\Models\JenisPembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $metode_pembayaran = MetodePembayaran::select('id_metode_pembayaran', 'logo', 'metode_pembayaran', 'via', 'status')
                            ->get();
        $bagi_hasil = PengaturanBagiHasil::select('besaran', 'status_jenis')->where('status', 'a')->first();
        $general = DB::table('pengaturan_pembayaran')
                    ->select('server_key', 'client_key', 'charge_url', 'durasi_waktu', 'satuan_durasi', 'harga_margin')
                    ->first();
        $jenis_bayar = JenisPembayaran::select('id_jenis_pembayaran', 'jenis_pembayaran', 'harga', 'jenis_biaya', 'status')
                        ->get();
        return view('app.pengaturan.pembayaran', compact('metode_pembayaran', 'bagi_hasil', 'general', 'jenis_bayar'));
    }
}
