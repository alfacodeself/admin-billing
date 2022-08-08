<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{DetailLangganan, JenisLangganan, Kategori, Langganan, Pelanggan, Produk, Transaksi};

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $total_transaksi = Transaksi::where('status_transaksi', 'settlement')->sum('total_bayar');
        $pelanggan_nonaktif = Pelanggan::where('status', 'n')->count();
        $langganan_kadaluarsa = DetailLangganan::where('status', 'a')->where('tanggal_kadaluarsa', '<', Carbon::now('+0700')->format('Y-m-d'))->count();
        $langganan_nonaktif = Langganan::where('status', 'n')->count();
        $presentase_kategori = Kategori::with('produk')->select('id_kategori', 'nama_kategori')->get()->map(function($kategori){
            $data['nama_kategori'] = $kategori->nama_kategori;
            $a = $kategori->produk->map(function($produk){
                return $data['jumlah_langganan'] = $produk->langganan()->count();

            })->toArray();
            $data['jumlah_langganan'] = array_sum($a);
            return $data;
        });
        $transaksi = Transaksi::select('tanggal_lunas', 'total_bayar')
                    ->whereYear('tanggal_lunas', Carbon::now('+0700')->format('Y'))
                    ->orderBy('tanggal_lunas')
                    ->get()
                    ->map(function($x){
                        $x->tanggal_lunas = Carbon::parse($x->tanggal_lunas)->translatedFormat('M');
                        return $x;
                    })->groupBy('tanggal_lunas');
        $kategori = Kategori::count();
        $produk = Produk::count();
        $semua_transaksi = Transaksi::count();
        $jenis_langganan = JenisLangganan::count();
        return view('app.dashboard', compact('presentase_kategori', 'transaksi', 'total_transaksi', 'pelanggan_nonaktif', 'langganan_kadaluarsa', 'langganan_nonaktif', 'kategori', 'produk', 'semua_transaksi', 'jenis_langganan'));
    }
}
