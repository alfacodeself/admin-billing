<?php

namespace App\Http\Controllers\Api\Mitra;

use Carbon\Carbon;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use App\Models\DokumenPelanggan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DetailMitraPelanggan;
use App\Http\Requests\PelangganRequest;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PelangganMitraController extends Controller
{
    public function index()
    {
        try {
            $pelanggan = DB::table('pelanggan')
                        ->join('detail_mitra_pelanggan', 'pelanggan.id_pelanggan', '=', 'detail_mitra_pelanggan.id_pelanggan')
                        ->select('pelanggan.id_pelanggan', 'pelanggan.nama_pelanggan', 'pelanggan.status', 'pelanggan.foto AS foto_pelanggan', 'detail_mitra_pelanggan.tanggal_masuk')
                        ->where('detail_mitra_pelanggan.status', 'a')
                        ->where('detail_mitra_pelanggan.id_mitra', auth('mitra')->id())
                        ->get()
                        ->map(function($pelanggan){
                            $pelanggan->foto_pelanggan = url($pelanggan->foto_pelanggan);
                            $pelanggan->status = $pelanggan->status == 'a' ? 'aktif' : 'nonaktif';
                            return $pelanggan;
                        });
            return response()->json([
                'status' => true,
                'message' => 'Berhasi memuat data pelanggan mitra!',
                'data' => $pelanggan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat data pelanggan mitra!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function store(PelangganRequest $request)
    {
        $request->validate(['password' => 'required|min:8']);
        // ============> Validasi Dokumen <=================
        $jenis_dokumen = JenisDokumen::where('status', 'a')->where('status_dokumen', 'p')->get();
        foreach ($jenis_dokumen as $dokumen) {
            $request->validate([
                Str::lower(str_replace(' ', '_', $dokumen->nama_dokumen)) => 'required'
            ]);
        }
        // =========> Validasi Desa <============
        $desa = DB::table('desa')->select('id_desa')->where('id_desa', $request->desa)->where('status', 'a')->first();
        // dd($desa);
        if ($desa == null) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat data pelanggan mitra!',
                'errors' => ['Desa tidak ditemukan']
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            // =========> Data Insert Pelanggan <==============
            $check = DB::table('pelanggan')->select(DB::raw('MAX(RIGHT(id_pelanggan, 5)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.05d", $temp);
                }
            } else {
                $code = "00001";
            }
            $foto = "fotopelanggan-". Str::random(5) . time() . '.' . $request->file('foto')->extension();
            $send = $request->file('foto')->storeAs('public/pelanggan/foto', $foto);
            $path = Storage::url($send);
            $pelanggan = Pelanggan::create([
                'id_pelanggan' => 'PL' . $code,
                'nik' => $request->nik,
                'foto' => $path,
                'nama_pelanggan' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nomor_hp' => $request->nomor_hp,
                'alamat' => $request->alamat,
                'id_desa' => $desa->id_desa,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => 'a',
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            // ==========> Data Dokumen Pelanggan <=========
            foreach ($jenis_dokumen as $dokumen) {
                $name = Str::lower(str_replace(' ', '_', $dokumen->nama_dokumen));
                $checkDok = DB::table('dokumen_pelanggan')->select(DB::raw('MAX(RIGHT(id_dokumen_pelanggan, 5)) AS kode'));
                if ($checkDok->count() > 0) {
                    foreach ($checkDok->get() as $c) {
                        $temp = ((int) $c->kode) + 1;
                        $codeDok = sprintf("%'.05d", $temp);
                    }
                } else {
                    $codeDok = "00001";
                }
                $ext = $request->file($name)->extension();
                $doc = "document-". Str::random(5) . time() . '.' . $ext;
                $store = $request->file($name)->storeAs('public/document/pelanggan', $doc);
                $path = Storage::url($store);
                DokumenPelanggan::create([
                    'id_dokumen_pelanggan' => 'DP' . $codeDok,
                    'id_pelanggan' => $pelanggan->id_pelanggan,
                    'id_jenis_dokumen' => $dokumen->id_jenis_dokumen,
                    'path_dokumen' => $path
                ]);
            }
            // ===========> Tambah ke pelanggan mitra <=============
            $checkPel = DB::table('detail_mitra_pelanggan')->select(DB::raw('MAX(RIGHT(id_detail_mitra_pelanggan, 5)) AS kode'));
            if ($checkPel->count() > 0) {
                foreach ($checkPel->get() as $c) {
                    $temp3 = ((int) $c->kode) + 1;
                    $codePel = sprintf("%'.05d", $temp3);
                }
            } else {
                $codePel = "00001";
            }
            DetailMitraPelanggan::create([
                'id_detail_mitra_pelanggan' => 'DMP' .  $codePel,
                'id_mitra' => auth('mitra')->id(),
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'status' => 'a',
                'tanggal_masuk' => Carbon::now('+0700')
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil manambah data pelanggan mitra!',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat data pelanggan mitra!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function pelanggan_nonaktif()
    {
        try {
            $pelanggan = DB::table('pelanggan')
                        ->join('detail_mitra_pelanggan', 'pelanggan.id_pelanggan', '=', 'detail_mitra_pelanggan.id_pelanggan')
                        ->select('pelanggan.id_pelanggan', 'pelanggan.nama_pelanggan', 'pelanggan.status', 'pelanggan.foto AS foto_pelanggan', 'detail_mitra_pelanggan.tanggal_masuk')
                        ->where('detail_mitra_pelanggan.status', 'a')
                        ->where('detail_mitra_pelanggan.id_mitra', auth('mitra')->id())
                        ->where('pelanggan.status', 'n')
                        ->get()
                        ->map(function($pelanggan){
                            $pelanggan->foto_pelanggan = url($pelanggan->foto_pelanggan);
                            $pelanggan->status = $pelanggan->status == 'a' ? 'aktif' : 'nonaktif';
                            return $pelanggan;
                        });
            return response()->json([
                'status' => true,
                'message' => 'Berhasi memuat data pelanggan mitra!',
                'data' => $pelanggan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat data pelanggan mitra!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function transaksi_pelanggan()
    {
        try {
            $transaksi = DB::table('transaksi')
                    ->join('langganan', 'langganan.id_langganan', '=', 'transaksi.id_langganan')
                    ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                    ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                    ->join('dana_mitra', 'transaksi.id_transaksi', '=', 'dana_mitra.id_transaksi')
                    ->join('detail_bagi_hasil', 'dana_mitra.id_detail_bagi_hasil', '=', 'detail_bagi_hasil.id_detail_bagi_hasil')
                    ->join('pengaturan_bagi_hasil', 'detail_bagi_hasil.id_pengaturan_bagi_hasil', '=', 'pengaturan_bagi_hasil.id_pengaturan_bagi_hasil')
                    ->join('mitra', 'detail_bagi_hasil.id_mitra', '=', 'mitra.id_mitra')
                    ->select('transaksi.id_transaksi', 'transaksi.total_bayar', 'transaksi.tanggal_lunas AS tanggal_pembayaran', 'langganan.kode_langganan', 'produk.nama_produk', 'pelanggan.nama_pelanggan', 'dana_mitra.hasil_dana_mitra', 'pengaturan_bagi_hasil.besaran', 'pengaturan_bagi_hasil.status_jenis')
                    ->where('transaksi.status_transaksi', 'settlement')
                    ->where('mitra.id_mitra', auth('mitra')->id())
                    ->get()
                    ->map(function($trx){
                        $trx->total_bayar = 'Rp.' . number_format($trx->total_bayar);
                        $trx->hasil_dana_mitra = 'Rp.' . number_format($trx->hasil_dana_mitra);
                        $trx->besaran = $trx->status_jenis == 'f' ? 'Rp.' . number_format($trx->besaran) : $trx->besaran . '%';
                        $trx->status_jenis = $trx->status_jenis == 'f' ? 'flat' : 'persentase';
                        return $trx;
                    });
            return response()->json([
                'status' => true,
                'message' => 'Berhasi memuat data transaksi pelanggan!',
                'data' => $transaksi
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat data transaksi pelanggan!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function detail_transaksi($id_transaksi)
    {
        try {
            $transaksi = Transaksi::with('detail_transaksi')->findOrFail($id_transaksi);
            return response()->json([
                'status' => true,
                'message' => 'Berhasi memuat detail transaksi!',
                'data' => $transaksi->detail_transaksi
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat detail trasaksi!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
}
