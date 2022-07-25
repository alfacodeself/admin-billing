<?php

namespace App\Http\Controllers\Api\Pelanggan;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProdukApiController extends Controller
{
    public function index()
    {
        try {
            $margin = DB::table('pengaturan_pembayaran')->select('harga_margin')->first();
            $produk = Kategori::join('produk', 'produk.id_kategori', '=', 'kategori.id_kategori')
                        ->select('kategori.*', 'produk.*')
                        ->selectRaw('produk.harga + ? AS withmargin', [$margin->harga_margin ?? 0])
                        ->where('kategori.status', 'a')
                        ->where('produk.status', 'a')
                        ->get()->map(function($produk){
                            $produk->fitur = explode('|', $produk->fitur);
                            return $produk;
                        });
            return response()->json([
                'status' => true,
                'message' => 'Berhasil memuat produk!',
                'data' => $produk
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat produk!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
}
