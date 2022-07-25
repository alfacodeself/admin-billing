<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Desa;
use App\Models\Produk;
use App\Models\Langganan;
use App\Models\Pelanggan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\JenisLangganan;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LanggananRequest;
use App\Models\DetailLangganan;

class LanggananController extends Controller
{
    public function index()
    {
        $langganan = DB::table('detail_langganan')->join('langganan', 'detail_langganan.id_langganan', '=', 'langganan.id_langganan')
                    ->join('jenis_langganan', 'detail_langganan.id_jenis_langganan', '=', 'jenis_langganan.id_jenis_langganan')
                    ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                    ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                    ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                    ->select('langganan.id_langganan', 'langganan.kode_langganan', 'langganan.alamat_pemasangan', 'langganan.status', 'langganan.histori', 'pelanggan.nama_pelanggan', 'produk.nama_produk', 'kategori.nama_kategori', 'jenis_langganan.lama_berlangganan')
                    ->where('detail_langganan.status', 'a')
                    ->where('langganan.status', '!=', 'pn')
                    ->get();
        return view('app.langganan.index', compact('langganan'));
    }
    public function create()
    {
        if ($nik = request()->nik) {
            try {
                $pelanggan = Pelanggan::with('desa', 'dokumen_pelanggan')->where('nik', $nik)->firstOrFail();
                if ($pelanggan->status == 'n') {
                    return redirect()->back()->with('danger', 'Pelanggan dengan NIK ' . $pelanggan->nik . 'atas nama ' . $pelanggan->nama_pelanggan . 'tidak aktif!');
                }
                $kategori = DB::table('kategori')
                                ->select('kategori.nama_kategori', 'kategori.id_kategori')
                                ->where('kategori.status', 'a')->get()->map(function($kategori) {
                                    $kategori->produk = DB::table('produk')->select('id_produk', 'nama_produk', 'deskripsi', 'harga', 'fitur')->where('status', 'a')->where('id_kategori', $kategori->id_kategori)->get()->map(function($produk) {
                                        $produk->fitur = explode('|', $produk->fitur);
                                        $produk->harga = 'Rp.' . number_format($produk->harga);
                                        return $produk;
                                    })->toArray();
                                    return $kategori;
                                });
                $provinsi = DB::table('provinsi')->where('status', 'a')->get();
                $jenis_langganan = DB::table('jenis_langganan')
                                    ->select('id_jenis_langganan', 'lama_berlangganan', 'banyak_tagihan')
                                    ->where('status', 'a')
                                    ->get();
                return view('app.langganan.create', compact('kategori', 'pelanggan', 'jenis_langganan', 'provinsi'));
            } catch (\Throwable $e) {
                return redirect()->route('langganan.create')->with('danger', 'Data pelanggan tidak ditemukan! ' . $e->getMessage());
            }
        }
        return view('app.langganan.create');
    }
    public function verifikasi()
    {
        $langganan = DB::table('detail_langganan')->join('langganan', 'detail_langganan.id_langganan', '=', 'langganan.id_langganan')
                    ->join('jenis_langganan', 'detail_langganan.id_jenis_langganan', '=', 'jenis_langganan.id_jenis_langganan')
                    ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                    ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                    ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                    ->select('langganan.id_langganan', 'langganan.kode_langganan', 'langganan.alamat_pemasangan', 'langganan.status', 'langganan.histori', 'pelanggan.nama_pelanggan', 'produk.nama_produk', 'kategori.nama_kategori', 'jenis_langganan.lama_berlangganan')
                    ->where('langganan.status', 'pn')
                    ->orWhere('langganan.status', 'dt')
                    ->get();
        return view('app.langganan.verifikasi', compact('langganan'));
    }
    public function store(LanggananRequest $request)
    {
        try {
            $pelanggan = Pelanggan::findOrFail($request->pelanggan);
            $desa = Desa::findOrFail($request->desa);
            $jenis_langganan = JenisLangganan::findOrFail($request->jenis_langganan);
            $produk = Produk::findOrFail($request->produk);
            $check = DB::table('langganan')->select(DB::raw('MAX(RIGHT(id_langganan, 5)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.05d", $temp);
                }
            } else {
                $code = "00001";
            }
            $langganan = Langganan::create([
                'id_langganan' => 'L' . $code,
                'id_produk' => $produk->id_produk,
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'kode_langganan' => Str::upper(Str::random(15)),
                'alamat_pemasangan' => $request->alamat,
                'id_desa' => $desa->id_desa,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'tanggal_verifikasi' => Carbon::now(),
                'status' => 'a',
                'histori' => 'Terdaftar|Diterima|Melakukan Pembayaran',
                'pesan' => 'Selamat! Langganan anda telah didaftarkan dan disetujui.',
            ]);
            $check2 = DB::table('detail_langganan')->select(DB::raw('MAX(RIGHT(id_detail_langganan, 5)) AS kode'));
            if ($check2->count() > 0) {
                foreach ($check2->get() as $c) {
                    $temp2 = ((int) $c->kode) + 1;
                    $code2 = sprintf("%'.05d", $temp2);
                }
            } else {
                $code2 = "00001";
            }
            DetailLangganan::create([
                'id_detail_langganan' => 'DL' . $code2,
                'id_langganan' => $langganan->id_langganan,
                'id_jenis_langganan' => $jenis_langganan->id_jenis_langganan,
                'sisa_tagihan' => $jenis_langganan->banyak_tagihan,
                'status' => 'a',
                'status_pembayaran' => 'bl'
            ]);
            return redirect()->route('langganan.index')->with('success', 'Berhasil mendaftarkan langganan dengan ID Langganan ' . $langganan->kode_langganan);
        } catch (\Throwable $e) {
            return redirect()->route('langganan.create')->with('danger', 'Gagal mendaftarkan langganan! ' . $e->getMessage());
        }
    }
    public function show($id)
    {
        $langganan = DB::table('langganan')->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                    ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                    ->join('desa', 'langganan.id_desa', '=', 'desa.id_desa')
                    ->join('kecamatan', 'desa.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                    ->join('kabupaten', 'kecamatan.id_kabupaten', '=', 'kabupaten.id_kabupaten')
                    ->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id_provinsi')
                    ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                    ->select('langganan.id_langganan', 'langganan.kode_langganan', 'produk.nama_produk', 'kategori.nama_kategori', 'langganan.status AS status_langganan', 'langganan.tanggal_verifikasi', 'langganan.tanggal_instalasi', 'langganan.histori', 'langganan.alamat_pemasangan', 'provinsi.nama_provinsi', 'kabupaten.nama_kabupaten', 'kecamatan.nama_kecamatan', 'desa.nama_desa', 'pelanggan.nama_pelanggan', 'pelanggan.nik', 'pelanggan.jenis_kelamin', 'pelanggan.status AS status_pelanggan', 'pelanggan.nomor_hp', 'pelanggan.email', 'pelanggan.id_pelanggan')
                    ->where('langganan.id_langganan', $id)
                    ->first();
        $detailLangganan = DB::table('detail_langganan')->where('id_langganan', $langganan->id_langganan)->where('status', 'a')->first();
        $semuaDetailLangganan = DB::table('detail_langganan')
                                ->join('jenis_langganan', 'detail_langganan.id_jenis_langganan', '=', 'jenis_langganan.id_jenis_langganan')
                                ->select('jenis_langganan.lama_berlangganan AS jenis_berlangganan', 'detail_langganan.*')
                                ->where('detail_langganan.id_langganan', $langganan->id_langganan)
                                ->get();
        // dd($detailLangganan);
        return view('app.langganan.show', compact('langganan', 'detailLangganan', 'semuaDetailLangganan'));
    }
    public function reject(Request $request, $id)
    {
        try {
            $langganan = Langganan::where('id_langganan', $id)->firstOrFail();
            $langganan->update([
                'pesan' => $request->pesan == null ? 'Pengajuan ditolak! Harap periksa kembali pengajuan dan syarat yang ditentukan!' : $request->pesan,
                'status' => 'dt'
            ]);
            return redirect()->route('langganan.verifikasi.index')->with('success', 'Berhasil menolak langganan!');
        } catch (\Throwable $th) {
            return back()->with('danger', 'Gagal menolak langganan! ' . $th->getMessage());
        }
    }
    public function verify($id)
    {
        try {
            $langganan = Langganan::where('id_langganan', $id)->firstOrFail();
            $langganan->update([
                'pesan' => 'Selamat! Pengajuan anda telah diterima, Langganan telah aktif.',
                'status' => 'a',
                'tanggal_verifikasi' => Carbon::now(),
                'histori' => $langganan->histori . '|Melakukan Pembayaran',
                'pesan' => 'Langganan telah disetujui! Harap segera melakukan pembayaran!'
            ]);
            return redirect()->route('langganan.verifikasi.index')->with('success', 'Berhasil menerima langganan!');
        } catch (\Throwable $th) {
            return back()->with('danger', 'Gagal menerima langganan! ' . $th->getMessage());
        }
    }
}
