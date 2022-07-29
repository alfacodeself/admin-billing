<?php

namespace App\Http\Controllers;

use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use App\Models\DetailBagiHasil;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\DB;
use App\Models\PengaturanBagiHasil;

class AlamatController extends Controller
{
    public function kabupaten($id)
    {
        $data = DB::table('kabupaten')->select('id_kabupaten', 'nama_kabupaten')->where('status', 'a')->where('id_provinsi', $id)->get();
        return response()->json($data);
    }
    public function kecamatan($id)
    {
        $data = DB::table('kecamatan')->select('id_kecamatan', 'nama_kecamatan')->where('status', 'a')->where('id_kabupaten', $id)->get();
        return response()->json($data);
    }
    public function desa($id)
    {
        $data = DB::table('desa')->select('id_desa', 'nama_desa', 'kode_pos')->where('status', 'a')->where('id_kecamatan', $id)->get();
        return response()->json($data);
    }
    public function status(Request $request)
    {
        if ($request->ajax()) {
            try {
                switch ($request->type) {
                    case 'metode':
                        $model = MetodePembayaran::where('id_metode_pembayaran', $request->value)->firstOrFail();
                        break;
                    case 'bagi_hasil':
                        $model = PengaturanBagiHasil::where('id_pengaturan_bagi_hasil', $request->value)->firstOrFail();
                        break;
                    case 'jenis_dokumen':
                        $model = JenisDokumen::where('id_jenis_dokumen', $request->value)->firstOrFail();
                        break;
                    default:
                        break;
                }
                if ($model->status == 'a') {
                    $data = ['status' => 'n'];
                }else {
                    $data = ['status' => 'a'];
                }
                $model->update($data);
                return response()->json('Berhasil mengubah status');
            } catch (\Throwable $th) {
                return response()->json('Gagal mengubah status! ' . $th->getMessage());
            }
        }
    }
    public function total(Request $request, $kode)
    {
        if ($request->ajax()) {
            $margin = DB::table('pengaturan_pembayaran')->select('harga_margin')->first();
            $langganan = DB::table('langganan')
                            ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                            ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                            ->select('tanggal_instalasi', 'pelanggan.id_pelanggan')
                            ->selectRaw('produk.harga + ? AS withmargin', [$margin->harga_margin])
                            ->where('langganan.kode_langganan', $kode)
                            ->first();
            $jenis_bayar = DB::table('jenis_pembayaran')->select('harga', 'jenis_biaya')->where('status', 'a')->get();
            $totalHarga = 0;
            $langganan->tanggal_instalasi == null ? $index = 0 : $index = 1;
            foreach ($jenis_bayar as $key => $jenis) {
                if ($key >= $index) {
                    if ($jenis->jenis_biaya == 'f') {
                        $totalHarga += $jenis->harga;
                    }
                    else {
                        $x = $jenis->harga / 100 * $langganan->withmargin;
                        $totalHarga += $x;
                    }
                }
            }
            $a = $langganan->withmargin * $request->tagihan;
            $totalHarga += $a;
            $b = 0;
            $detail_mitra = DB::table('detail_mitra_pelanggan')->where('id_pelanggan', $langganan->id_pelanggan)->where('status', 'a')->first();
            if ($detail_mitra != null) {
                $biaya_mitra = DetailBagiHasil::with('pengaturan_bagi_hasil', 'mitra')->where('id_mitra', $detail_mitra->id_mitra)->where('status', 'a')->first();
                if ($biaya_mitra !== null) {
                    if ($biaya_mitra->pengaturan_bagi_hasil->status_jenis == 'f') {
                        $b += $biaya_mitra->pengaturan_bagi_hasil->besaran;
                    }
                    else {
                        $x = $biaya_mitra->pengaturan_bagi_hasil->besaran / 100 * $langganan->withmargin;
                        $b += $x;
                    }
                }
            }
            $totalHarga += $b;
            return response()->json($totalHarga);
        }
    }
}
