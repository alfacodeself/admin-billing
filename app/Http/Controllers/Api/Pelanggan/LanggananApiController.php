<?php

namespace App\Http\Controllers\Api\Pelanggan;

use Carbon\Carbon;
use App\Models\Desa;
use App\Models\Produk;
use App\Models\Langganan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\JenisLangganan;
use App\Models\DetailLangganan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\LanggananResource;
use Symfony\Component\HttpFoundation\Response;

class LanggananApiController extends Controller
{
    public function index()
    {
        try {
            $langganan = auth()->guard('pelanggan')->user()->langganan;
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
            $langganan = DB::table('langganan')
                        ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                        ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                        ->join('desa', 'langganan.id_desa', '=', 'desa.id_desa')
                        ->join('kecamatan', 'desa.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                        ->join('kabupaten', 'kecamatan.id_kabupaten', '=', 'kabupaten.id_kabupaten')
                        ->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id_provinsi')
                        ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                        ->select('langganan.id_langganan', 'langganan.kode_langganan', 'produk.nama_produk', 'kategori.nama_kategori', 'langganan.status AS status_langganan', 'langganan.tanggal_verifikasi', 'langganan.tanggal_instalasi', 'langganan.histori', 'langganan.alamat_pemasangan', 'provinsi.nama_provinsi', 'kabupaten.nama_kabupaten', 'kecamatan.nama_kecamatan', 'desa.nama_desa', 'langganan.rt', 'langganan.rw', 'desa.kode_pos')
                        ->selectRaw('produk.harga + ? AS withmargin', [$margin->harga_margin ?? 0])
                        ->where('langganan.id_langganan', $id)
                        ->where('langganan.id_pelanggan', auth()->id())
                        ->first();
            $detailLangganan = DB::table('detail_langganan')->where('id_langganan', $langganan->id_langganan)->where('status', 'a')->first();
            $semuaDetailLangganan = DB::table('detail_langganan')
                                    ->join('jenis_langganan', 'detail_langganan.id_jenis_langganan', '=', 'jenis_langganan.id_jenis_langganan')
                                    ->select('jenis_langganan.lama_berlangganan AS jenis_berlangganan', 'detail_langganan.*')
                                    ->where('detail_langganan.id_langganan', $langganan->id_langganan)
                                    ->get();
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
            $langganan = Langganan::where('kode_langganan', $kode)->firstOrFail();
            $detail_langganan = DetailLangganan::where('id_langganan', $langganan->id_langganan)->where('status', 'a')->firstOrFail();
            if ($langganan->status != 'pn' && $langganan->status != 'dt') {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengubah langganan.',
                    'errors' => ['Langganan bukan dalam pengajuan atau sedang ditolak!']
                ], Response::HTTP_BAD_REQUEST);
            }
            $produk = Produk::where('id_produk', $valid['produk'])->where('status', 'a')->first();
            $pelanggan = auth()->guard('pelanggan')->user();
            foreach ($pelanggan->langganan as $langganan) {
                if ($langganan->produk->kategori == $produk->kategori && $langganan->produk->id_produk != $produk->id_produk) {
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
            $langganan->update([
                'id_produk' => $produk->id_produk,
                'alamat_pemasangan' => $request->alamat,
                'id_desa' => $desa->id_desa,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            $detail_langganan->update([
                'id_jenis_langganan' => $jenis_langganan->id_jenis_langganan,
                'sisa_tagihan' => $jenis_langganan->banyak_tagihan,
            ]);
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
}
