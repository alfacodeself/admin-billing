<?php

namespace App\Http\Controllers\Api\Pelanggan;

use App\Models\Provinsi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AlamatApiController extends Controller
{
    public function provinsi()
    {
        try {
            $prov = Provinsi::select('id_provinsi', 'nama_provinsi')->where('status', 'a')->get();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil data provinsi!',
                'data' => $prov
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data provinsi!',
                'errors' => $th->getMessage()
            ]);
        }
    }
    public function kabupaten($id)
    {
        try {
            $data = DB::table('kabupaten')->select('id_kabupaten', 'nama_kabupaten')->where('status', 'a')->where('id_provinsi', $id)->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data kabupaten!',
                'errors' => $th->getMessage()
            ]);
        }
    }
    public function kecamatan($id)
    {
        try {
            $data = DB::table('kecamatan')->select('id_kecamatan', 'nama_kecamatan')->where('status', 'a')->where('id_kabupaten', $id)->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data kecamatan!',
                'errors' => $th->getMessage()
            ]);
        }
    }
    public function desa($id)
    {
        try {
            $data = DB::table('desa')->select('id_desa', 'nama_desa', 'kode_pos')->where('status', 'a')->where('id_kecamatan', $id)->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data kecamatan!',
                'errors' => $th->getMessage()
            ]);
        }
    }
}
