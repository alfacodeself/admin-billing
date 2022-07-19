<?php

namespace App\Http\Controllers;

use App\Models\JenisDokumen;
use App\Models\MetodePembayaran;
use App\Models\PengaturanBagiHasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                            ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                            ->selectRaw('produk.harga + ? AS withmargin', [$margin->harga_margin])
                            ->where('langganan.kode_langganan', $kode)
                            ->first();
            $jenis_bayar = DB::table('jenis_pembayaran')->select('harga', 'jenis_biaya')->where('status', 'a')->get();
            $totalHarga = 0;
            foreach ($jenis_bayar as $jenis) {
                if ($jenis->jenis_biaya == 'f') {
                    $totalHarga += $jenis->harga;
                }
                else {
                    $x = $jenis->harga / 100 * $langganan->withmargin;
                    $totalHarga += $x;
                }
            }
            $a = $langganan->withmargin * $request->tagihan;
            $totalHarga += $a;
            return response()->json($totalHarga);
        }
    }
}
