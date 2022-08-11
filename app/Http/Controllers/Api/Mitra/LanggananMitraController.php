<?php

namespace App\Http\Controllers\Api\Mitra;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LanggananMitraController extends Controller
{
    public function index()
    {
        try {
            $langganan = DB::table('langganan')
                        ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                        ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                        ->join('detail_mitra_pelanggan', 'pelanggan.id_pelanggan', '=', 'detail_mitra_pelanggan.id_pelanggan')
                        ->select('langganan.kode_langganan', 'produk.nama_produk', 'langganan.alamat_pemasangan', 'pelanggan.nama_pelanggan', 'pelanggan.status')
                        ->where('detail_mitra_pelanggan.id_mitra', auth('mitra')->id())
                        ->where('detail_mitra_pelanggan.status', 'a')
                        ->get()->map(function($langganan){
                            $langganan->status = $langganan->status == 'a' ? 'aktif' : 'nonaktif';
                            return $langganan;
                        });
            return response()->json([
                'status' => true,
                'message' => 'Berhasil memuat langganan mitra!',
                'data' => $langganan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat langganan mitra!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function langganan_kadaluarsa()
    {
        try {
            $langganan = DB::table('langganan')
                        ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                        ->join('detail_langganan', 'langganan.id_langganan', '=', 'detail_langganan.id_langganan')
                        ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                        ->join('detail_mitra_pelanggan', 'pelanggan.id_pelanggan', '=', 'detail_mitra_pelanggan.id_pelanggan')
                        ->select('langganan.kode_langganan', 'produk.nama_produk', 'langganan.alamat_pemasangan', 'pelanggan.nama_pelanggan', 'pelanggan.status')
                        ->where('detail_langganan.status', 'a')
                        ->where('detail_langganan.tanggal_kadaluarsa', '<', Carbon::now('+0700')->format('Y-m-d'))
                        ->where('detail_mitra_pelanggan.id_mitra', auth('mitra')->id())
                        ->where('detail_mitra_pelanggan.status', 'a')
                        ->get()->map(function($langganan){
                            $langganan->status = $langganan->status == 'a' ? 'aktif' : 'nonaktif';
                            return $langganan;
                        });
            return response()->json([
                'status' => true,
                'message' => 'Berhasil memuat langganan mitra!',
                'data' => $langganan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat langganan mitra!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function langganan_nonaktif()
    {
        try {
            $langganan = DB::table('langganan')
                        ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                        ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                        ->join('detail_mitra_pelanggan', 'pelanggan.id_pelanggan', '=', 'detail_mitra_pelanggan.id_pelanggan')
                        ->select('langganan.kode_langganan', 'produk.nama_produk', 'langganan.alamat_pemasangan', 'pelanggan.nama_pelanggan', 'pelanggan.status')
                        ->where('langganan.status', 'n')
                        ->where('detail_mitra_pelanggan.id_mitra', auth('mitra')->id())
                        ->where('detail_mitra_pelanggan.status', 'a')
                        ->get()->map(function($langganan){
                            $langganan->status = $langganan->status == 'a' ? 'aktif' : 'nonaktif';
                            return $langganan;
                        });
            return response()->json([
                'status' => true,
                'message' => 'Berhasil memuat langganan mitra!',
                'data' => $langganan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat langganan mitra!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function jadwal_instalasi()
    {
        try {
            $langganan = DB::table('langganan')
                        ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                        ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                        ->join('detail_mitra_pelanggan', 'pelanggan.id_pelanggan', '=', 'detail_mitra_pelanggan.id_pelanggan')
                        ->select('langganan.kode_langganan', 'produk.nama_produk', 'langganan.alamat_pemasangan', 'pelanggan.nama_pelanggan', 'pelanggan.status', 'langganan.tanggal_instalasi')
                        ->where('langganan.status', 'pmi')
                        ->where('detail_mitra_pelanggan.id_mitra', auth('mitra')->id())
                        ->where('detail_mitra_pelanggan.status', 'a')
                        ->get()->map(function($langganan){
                            $langganan->status = $langganan->status == 'pmi' ? 'pemasangan instalasi' : 'nonaktif';
                            return $langganan;
                        });
            return response()->json([
                'status' => true,
                'message' => 'Berhasil memuat jadwal instalasi langganan mitra!',
                'data' => $langganan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat jadwal instalasi langganan mitra!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
}
