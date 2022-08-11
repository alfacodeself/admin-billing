<?php

namespace App\Http\Controllers\Api\Mitra;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PemetaanLayananMitraController extends Controller
{
    public function __invoke()
    {
        try {
            $langganan = DB::table('langganan')
                        ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                        ->join('desa', 'langganan.id_desa', '=', 'desa.id_desa')
                        ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                        ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                        ->join('detail_mitra_pelanggan', 'pelanggan.id_pelanggan', '=', 'detail_mitra_pelanggan.id_pelanggan')
                        ->select('langganan.kode_langganan', 'produk.nama_produk', 'kategori.nama_kategori', 'langganan.alamat_pemasangan', 'langganan.latitude', 'langganan.longitude', 'pelanggan.nama_pelanggan', 'pelanggan.status', 'langganan.tanggal_instalasi', 'langganan.tanggal_verifikasi', 'desa.kode_pos')
                        ->where('detail_mitra_pelanggan.id_mitra', auth('mitra')->id())
                        ->where('detail_mitra_pelanggan.status', 'a')
                        ->get();
            $data = [];
            foreach ($langganan as $key => $l) {
                if ($l->status == 'a') {
                    $s = 'Aktif';
                }
                elseif ($l->status == 'n') {
                    $s = 'Nonaktif';
                }
                elseif ($l->status == 'pn') {
                    $s = 'Pengajuan';
                }
                elseif ($l->status == 'pni') {
                    $s = 'Pengajuan Instalasi';
                }
                elseif ($l->status == 'pmi') {
                    $s = 'Pemasangan Instalasi';
                }
                elseif ($l->status == 'dt') {
                    $s = 'Ditolak';
                }
                elseif ($l->status == 'dtr') {
                    $s = 'Diterima';
                }
                $d = [
                    $l->kode_langganan . ' | ' . $l->nama_pelanggan,
                    $l->latitude,
                    $l->longitude,
                    $key+1,
                    $l->nama_produk,
                    $l->nama_kategori,
                    $l->alamat_pemasangan . '. Kode Pos ' . $l->kode_pos,
                    $l->tanggal_instalasi == null ? '-' : $l->tanggal_instalasi,
                    $l->tanggal_verifikasi == null ? false : true,
                    $l->status = $s
                ];
                array_push($data, $d);
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil memuat pemetaan instalasi langganan mitra!',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat pemetaan instalasi langganan mitra!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
}
