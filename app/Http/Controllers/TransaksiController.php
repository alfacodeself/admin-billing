<?php

namespace App\Http\Controllers;

use App\Models\DetailLangganan;
use App\Models\Langganan;
use App\Models\MetodePembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('metode_pembayaran', 'petugas', 'langganan')->paginate(10);
        return view('app.transaksi.index', compact('transaksi'));
    }
    public function create()
    {
        if ($kode = request()->langganan) {
            try {
                $margin = DB::table('pengaturan_pembayaran')->select('harga_margin')->first();
                $langganan = DB::table('langganan')
                            ->join('detail_langganan', 'langganan.id_langganan', '=', 'detail_langganan.id_langganan')
                            ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                            ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                            ->join('desa', 'langganan.id_desa', '=', 'desa.id_desa')
                            ->join('kecamatan', 'desa.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                            ->join('kabupaten', 'kecamatan.id_kabupaten', '=', 'kabupaten.id_kabupaten')
                            ->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id_provinsi')
                            ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                            ->select('langganan.id_langganan', 'langganan.kode_langganan', 'produk.nama_produk', 'kategori.nama_kategori', 'langganan.status AS status_langganan', 'langganan.tanggal_verifikasi', 'langganan.tanggal_instalasi', 'langganan.histori', 'langganan.alamat_pemasangan', 'provinsi.nama_provinsi AS provinsi', 'kabupaten.nama_kabupaten AS kabupaten', 'kecamatan.nama_kecamatan AS kecamatan', 'desa.nama_desa AS desa', 'pelanggan.id_pelanggan', 'pelanggan.nama_pelanggan', 'pelanggan.nik', 'pelanggan.jenis_kelamin', 'pelanggan.status AS status_pelanggan', 'pelanggan.nomor_hp', 'pelanggan.email', 'detail_langganan.tanggal_mulai', 'detail_langganan.tanggal_kadaluarsa', 'detail_langganan.tanggal_selesai', 'detail_langganan.sisa_tagihan', 'detail_langganan.status_pembayaran')
                            ->selectRaw('produk.harga + ? AS withmargin', [$margin->harga_margin])
                            ->where('langganan.kode_langganan', $kode)
                            ->where('detail_langganan.status', 'a')
                            ->first();
                // dd($langganan);
                $transaksi = Transaksi::with('metode_pembayaran', 'petugas')->where('id_langganan', $langganan->id_langganan)->get();
                $jenis_bayar = DB::table('jenis_pembayaran')->where('status', 'a')->get();
                $metode_bayar = DB::table('metode_pembayaran')->where('status', 'a')->get();
                // dd($langganan->produk);
                return view('app.transaksi.create', compact('langganan', 'jenis_bayar', 'transaksi', 'metode_bayar'));
            } catch (\Throwable $e) {
                return redirect()->route('transaksi.create')->with('danger', 'Data langganan tidak ditemukan! ' . $e->getMessage());
            }
        }
        return view('app.transaksi.create');
    }
    public function store(Request $request, $kode)
    {
        $langganan = Langganan::with('produk')->where('kode_langganan', $kode)->firstOrFail();
        $detail = DetailLangganan::where('id_langganan', $langganan->id_langganan)->firstOrFail();
        $request->validate([
            'jumlah_tagihan' => 'required|numeric|min:1|max:'. $detail->sisa_tagihan,
            'metode_bayar' => 'required'
        ], [
            'jumlah_tagihan.required' => 'Tagihan tidak boleh kosong!',
            'jumlah_tagihan.numeric' => 'Tagihan harus berupa angka!',
            'jumlah_tagihan.min' => 'Tagihan tidak boleh lebih kecil dari 1!',
            'jumlah_tagihan.max' => 'Tagihan tidak boleh lebih besar dari ' . $detail->sisa_tagihan . '!',
            'metode_bayar.required' => 'Metode pembayaran tidak boleh kosong!'
        ]);
        try {
            $metode = MetodePembayaran::where('id_metode_pembayaran', $request->metode_bayar)->firstOrFail();
            // Data sementara
            $jenis_bayar = DB::table('jenis_pembayaran')->select('harga', 'jenis_biaya')->where('status', 'a')->get();
            $totalHarga = 0;
            foreach ($jenis_bayar as $jenis) {
                // Kalau tipe flat
                if ($jenis->jenis_biaya == 'f') {
                    $totalHarga += $jenis->harga;
                }
                // Kalau presentase
                else {
                    $x = $jenis->harga / 100 * $langganan->produk->withmargin;
                    $totalHarga += $x;
                }
            }
            // Harga produk yang sudah di margin + Tagihan yang akan dibayar
            $a = $langganan->produk->withmargin * $request->jumlah_tagihan;
            // Total
            $totalHarga += $a;
            $data = [
                'ID Langganan'  =>  $langganan->kode_langganan,
                'Produk'        =>  $langganan->produk->nama_produk,
                'Harga Produk'  =>  'Rp.' . number_format($langganan->produk->harga),
                'Harga + Margin'=>  'Rp.' . number_format($langganan->produk->withmargin),
                'Tagihan'       =>  $request->tagihan . ' Yang akan dibayar!',
                'Total Bayar'   =>  'Rp.' . number_format($totalHarga),
                'Metode Bayar'  =>  $metode->metode_pembayaran,
                'Via Pembayaran'=>  $metode->via,
                'logo'          =>  url($metode->logo),
            ];
            dd($data);
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', 'Gagal membuat transaksi!' . $th->getMessage());
        }
    }
    public function show()
    {
        return view('app.transaksi.show');
    }
}
