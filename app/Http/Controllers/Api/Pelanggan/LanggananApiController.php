<?php

namespace App\Http\Controllers\Api\Pelanggan;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\LanggananResource;
use Symfony\Component\HttpFoundation\Response;
use App\Models\{Desa, Produk, Langganan, JenisLangganan, DetailLangganan};

class LanggananApiController extends Controller
{
    public function index()
    {
        try {
            $langganan = Cache::remember('langganan-index', 60*60*24, function () {
                return auth()->guard('pelanggan')->user()->langganan;
            });
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil langganan.',
                'data' => LanggananResource::collection($langganan)
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => true,
                'message' => 'Gagal mengambil langganan.',
                'errors' => [$th->getMessage()]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function jenis_langganan()
    {
        try {
            $jenis_langganan = JenisLangganan::select('id_jenis_langganan', 'lama_berlangganan', 'banyak_tagihan')->where('status', 'a')->get();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil langganan.',
                'data' => $jenis_langganan
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil langganan.',
                'errors' => [$th->getMessage()]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function store(Request $request)
    {
        // Validasi request
        $valid = $request->validate([
            'produk' => 'required',
            'jenis_langganan' => 'required',
            'desa' => 'required',
            'rt' => 'required|numeric|min:1',
            'rw' => 'required|numeric|min:1',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ], [
            'produk.required' => 'Produk tidak boleh kosong',
            'jenis_langganan.required' => 'Berlangganan tidak boleh kosong',
            'desa.required' => 'Desa tidak boleh kosong',
            'rt.required' => 'RT tidak boleh kosong',
            'rt.numeric' => 'RT harus berupa angka',
            'rt.min' => 'RT minimal 1',
            'rw.numeric' => 'RW harus berupa angka',
            'rw.min' => 'RW minimal 1',
            'rw.required' => 'RW tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'latitude.required' => 'Harap pilih alamat pada map',
            'longitude.required' => 'Harap pilih alamat pada map',
        ]);
        try {
            // Cek produk, jenis langganan, dan desa
            $produk = Produk::where('id_produk', $valid['produk'])->where('status', 'a')->first();
            $pelanggan = auth()->guard('pelanggan')->user();
            foreach ($pelanggan->langganan as $langganan) {
                if ($langganan->produk->kategori == $produk->kategori) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Gagal membuat langganan.',
                        'errors' => ['Anda tidak bisa mengajukan langganan dengan jenis produk yang sama!']
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }
            $jenis_langganan = JenisLangganan::where('id_jenis_langganan', $valid['jenis_langganan'])->where('status', 'a')->first();
            $desa = Desa::where('id_desa', $valid['desa'])->where('status', 'a')->first();
            if ($produk == null || $jenis_langganan == null || $desa == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal membuat langganan.',
                    'errors' => ['Produk, jenis berlangganan, atau desa tidak ditemukan!']
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            // Check untuk membuat id
            $check = DB::table('langganan')->select(DB::raw('MAX(RIGHT(id_langganan, 5)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.05d", $temp);
                }
            } else {
                $code = "00001";
            }
            // Store langganann
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
                'status' => 'pn',
                'histori' => 'Terdaftar',
                'pesan' => 'Berhasil mengajukan langganan! Harap menunggu verifikasi admin.',
            ]);
            // Check id detail
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
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengajukan langganan. ID Langganan anda adalah ' . $langganan->kode_langganan
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat langganan.',
                'errors' => [$th->getMessage()]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function show($id)
    {
        try {
            $margin = DB::table('pengaturan_pembayaran')->select('harga_margin')->first();
            $langganan = Cache::remember('langganan-show', 60*60*60, function() use ($margin, $id){
                return DB::table('langganan')
                ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                ->join('desa', 'langganan.id_desa', '=', 'desa.id_desa')
                ->join('kecamatan', 'desa.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                ->join('kabupaten', 'kecamatan.id_kabupaten', '=', 'kabupaten.id_kabupaten')
                ->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id_provinsi')
                ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                ->select('langganan.id_langganan', 'langganan.kode_langganan', 'produk.nama_produk', 'kategori.nama_kategori', 'langganan.status AS status_langganan', 'langganan.tanggal_verifikasi', 'langganan.tanggal_instalasi', 'langganan.histori', 'langganan.alamat_pemasangan', 'provinsi.nama_provinsi', 'kabupaten.nama_kabupaten', 'kecamatan.nama_kecamatan', 'desa.nama_desa', 'langganan.rt', 'langganan.rw', 'desa.kode_pos', 'langganan.latitude', 'langganan.longitude', 'langganan.pesan')
                ->selectRaw('produk.harga + ? AS withmargin', [$margin->harga_margin ?? 0])
                ->where('langganan.id_langganan', $id)
                ->where('langganan.id_pelanggan', auth()->id())
                ->first();
            });
            $detailLangganan = Cache::remember('detail-langganan-show', 60*60*60, function() use ($langganan){
                return DB::table('detail_langganan')->where('id_langganan', $langganan->id_langganan)->where('status', 'a')->first();
            });
            $semuaDetailLangganan = Cache::remember('semua-detail-langganan', 60*60*60, function () use ($langganan){
                return DB::table('detail_langganan')
                ->join('jenis_langganan', 'detail_langganan.id_jenis_langganan', '=', 'jenis_langganan.id_jenis_langganan')
                ->select('jenis_langganan.lama_berlangganan AS jenis_berlangganan', 'detail_langganan.*')
                ->where('detail_langganan.id_langganan', $langganan->id_langganan)
                ->get();
            });
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil langganan.',
                'data' => [
                    'langganan' => $langganan,
                    'detail_langganan' => $detailLangganan,
                    'histori_langganan' => $semuaDetailLangganan
                ]
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil langganan.',
                'errors' => [$th->getMessage()]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update($kode, Request $request)
    {
        // Validasi request
        $valid = $request->validate([
            'produk' => 'nullable',
            'jenis_langganan' => 'nullable',
            'desa' => 'nullable',
            'rt' => 'nullable|numeric|min:1',
            'rw' => 'nullable|numeric|min:1',
            'alamat' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable'
        ]);
        try {
            // Cek langganan
            $langganan = Langganan::where('kode_langganan', $kode)->firstOrFail();
            if ($langganan->pelanggan->id_pelanggan != auth('pelanggan')->id()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengubah langganan!',
                    'errors' => ['Anda tidak dapat mengakses halaman!']
                ], Response::HTTP_UNAUTHORIZED);
            }
            // Cek detail langganan
            $detail_langganan = DetailLangganan::where('id_langganan', $langganan->id_langganan)->where('status', 'a')->firstOrFail();
            // Kalau status langganan bukan pengajuan atau ditolak
            if ($langganan->status != 'pn' && $langganan->status != 'dt') {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengubah langganan.',
                    'errors' => ['Langganan bukan dalam pengajuan atau sedang ditolak!']
                ], Response::HTTP_BAD_REQUEST);
            }
            // Kalau ada produk
            if ($request->has('produk')) {
                $produk = Produk::where('id_produk', $valid['produk'])->where('status', 'a')->first();
                // Kalau produk ga ditemukan
                if ($produk == null) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Gagal membuat langganan.',
                        'errors' => ['Produk tidak ditemukan!']
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
                $pelanggan = auth()->guard('pelanggan')->user();
                // Valid agar pelanggan tidak dapat memilih kategori yang sama kecuali produk sebelumnya

                foreach ($pelanggan->langganan as $l) {
                    if ($l->produk->kategori == $produk->kategori && $l->produk->id_produk != $produk->id_produk) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Gagal membuat langganan.',
                            'errors' => ['Anda tidak bisa mengajukan langganan dengan jenis produk yang sama!']
                        ], Response::HTTP_UNPROCESSABLE_ENTITY);
                    }
                }
            }
            // Kalau ada jenis langganan
            if ($request->has('jenis_langganan')) {
                $jenis_langganan = JenisLangganan::where('id_jenis_langganan', $valid['jenis_langganan'])->where('status', 'a')->first();
                // Kalau jenis langganan ga ditemukan
                if ($jenis_langganan == null) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Gagal membuat langganan.',
                        'errors' => ['Jenis langganan tidak ditemukan!']
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }
            if ($request->has('desa')) {
                $desa = Desa::where('id_desa', $valid['desa'])->where('status', 'a')->first();
                if ($desa == null) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Gagal membuat langganan.',
                        'errors' => ['Desa tidak ditemukan!']
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }
            $langganan->update([
                'id_produk' => $produk->id_produk ?? $langganan->id_produk,
                'alamat_pemasangan' => $request->alamat == null ? $langganan->alamat_pemasangan : $valid['alamat'],
                'id_desa' => $desa->id_desa ?? $langganan->id_desa,
                'rt' => $request->rt == null ? $langganan->rt : $valid['rt'],
                'rw' => $request->rw == null ? $langganan->rw : $valid['rw'],
                'latitude' => $request->latitude == null ? $langganan->latitude : $valid['latitude'],
                'longitude' => $request->longitude == null ? $langganan->longitude : $valid['longitude'],
            ]);
            if ($request->has('jenis_langganan')) {
                $detail_langganan->update([
                    'id_jenis_langganan' => $jenis_langganan->id_jenis_langganan,
                    'sisa_tagihan' => $jenis_langganan->banyak_tagihan,
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengubah langganan!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengubah langganan',
                'errors' => [$th->getMessage()]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function transaksiLangganan($kode)
    {
        try {   
            $langganan = Langganan::where('kode_langganan', $kode)->where('id_pelanggan', auth()->id())->firstOrFail();
            $transaksi = Cache::remember('langganan-transaksi-langganan', 60*60*60, function () use ($langganan) {
                return $langganan->transaksi->load('detail_transaksi', 'metode_pembayaran', 'petugas', 'langganan')->map(function($trx) {
                    $trx->detail_transaksi->map(function($detTrx) use ($trx){
                        return $detTrx->nama_pembayaran = $detTrx->id_jenis_pembayaran == null ? $trx->langganan->produk->nama_produk : $detTrx->jenis_pembayaran->jenis_pembayaran;
                    });
                    $trx->metode_pembayaran->logo = url($trx->metode_pembayaran->logo);
                    return $trx;
                });
            });
            return response()->json([
                'status' => true,
                'message' => 'Berhasil memuat transaksi langganan!',
                'data' => $transaksi
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat transaksi langganan!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function pengajuan($kode)
    {
        try {
            $langganan = Langganan::where('kode_langganan', $kode)->where('id_pelanggan', auth()->id())->firstOrFail();
            if ($langganan->status != 'dt') {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengubah langganan.',
                    'errors' => ['Status langganan tidak sedang ditolak!']
                ], Response::HTTP_BAD_REQUEST);
            }
            $langganan->update([
                'status' => 'pn'
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil melakukan pengajuan!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat transaksi langganan!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function set_tanggal_instalasi(Request $request, $kode)
    {
        $request->validate([
            'tanggal_pengajuan' => 'required|date'
        ], [
            'tanggal_pengajuan.required' => 'Tanggal pengajuan tidak boleh kosong!',
            'tanggal_pengajuan.date' => 'Format tanggal salah!'
        ]);
        try {
            $langganan = Langganan::where('kode_langganan', $kode)->where('id_pelanggan', auth()->id())->firstOrFail();
            if ($langganan->pelanggan->id_pelanggan != auth('pelanggan')->id()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengajukan tanggal instalasi!',
                    'errors' => ['Anda tidak dapat mengakses halaman!']
                ], Response::HTTP_UNAUTHORIZED);
            }
            if ($langganan->tanggal_instalasi !== null && $langganan->tanggal_instalasi > Carbon::now('+0700')->format('Y-m-d')) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengajukan tanggal instalasi langganan!',
                    'errors' => ['Anda sudah mengajukan tanggal instalasi yang valid!']
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            if ($langganan->status != 'pni' && $langganan->status != 'pmi') {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengajukan tanggal instalasi langganan!',
                    'errors' => ['Status langganan tidak dalam pengajuan dan pemasangan instalasi!']
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            if (Carbon::parse($request->tanggal_pengajuan) < Carbon::now('+0700')) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengajukan tanggal instalasi langganan!',
                    'errors' => ['Tanggal pengajuan harus lebih besar dari tanggal sekarang!']
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $langganan->update([
                'status' => 'pmi',
                'tanggal_instalasi' => Carbon::parse($request->tanggal_pengajuan),
                'pesan' => 'Berhasil mengajukan tanggal instalasi!'
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengajukan tanggal instalasi langganan!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengajukan tanggal instalasi langganan!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function approve($kode)
    {
        try {
            $langganan = Langganan::where('kode_langganan', $kode)->where('id_pelanggan', auth('pelanggan')->id())->firstOrFail();
            if ($langganan->pelanggan->id_pelanggan != auth('pelanggan')->id()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal meyetujui penyelesaian instalasi!',
                    'errors' => ['Anda tidak dapat mengakses halaman!']
                ], Response::HTTP_UNAUTHORIZED);
            }
            $detail_langganan = DetailLangganan::where('id_langganan', $langganan->id_langganan)->where('status', 'a')->firstOrFail();
            $bulan = $detail_langganan->jenis_langganan->banyak_tagihan;
            $kadaluarsa = $detail_langganan->jenis_langganan->banyak_tagihan - $detail_langganan->sisa_tagihan;
            if ($langganan->status != 'pmi') {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengajukan sudah instalasi langganan!',
                    'errors' => ['Status langganan tidak dalam pemasangan instalasi!']
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $langganan->update([
                'status' => 'a',
                'pesan' => 'Langganan anda telah aktif!'
            ]);
            $detail_langganan->update([
                'tanggal_mulai' => Carbon::now('+0700')->format('Y-m-d'),
                'tanggal_kadaluarsa' => Carbon::now('+0700')->addMonths($kadaluarsa)->format('Y-m-d'),
                'tanggal_selesai' => Carbon::now('+0700')->addMonths($bulan)->format('Y-m-d')
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengajukan sudah instalasi langganan! Langganan telah aktif!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengajukan tanggal instalasi langganan!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
}
