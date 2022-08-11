<?php

namespace App\Http\Controllers\Api\Pelanggan;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DetailBagiHasil;
use Illuminate\Support\Facades\DB;
use App\Http\Midtrans\BankTransfer;
use App\Http\Controllers\Controller;
use App\Http\Price\DetailTransaction;
use Symfony\Component\HttpFoundation\Response;
use App\Models\{DanaMitra, Langganan, Transaksi, DetailLangganan, DetailTransaksi, MetodePembayaran};
use Illuminate\Support\Facades\Cache;

class TransaksiApiController extends Controller
{
    public function transaksi_pelanggan()
    {
        try {
            $transaksi = Cache::remember('transaksi-index', 60 * 60 * 24, function(){
                return Transaksi::join('langganan', 'transaksi.id_langganan', '=', 'langganan.id_langganan')
                        ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                        ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                        ->join('metode_pembayaran', 'transaksi.id_metode_pembayaran', '=', 'metode_pembayaran.id_metode_pembayaran')
                        ->select('transaksi.id_transaksi', 'langganan.kode_langganan', 'produk.nama_produk', 'transaksi.total_bayar', 'metode_pembayaran.metode_pembayaran','metode_pembayaran.logo',  'transaksi.nomor_va', 'transaksi.status_transaksi', 'transaksi.tanggal_transaksi', 'transaksi.tanggal_lunas')
                        ->where('pelanggan.id_pelanggan', auth('pelanggan')->id())
                        ->get()->map(function($trx){
                            $trx->logo = url($trx->logo);
                            return $trx;
                        });
            });
            return response()->json([
                'status' => true,
                'message' => "Berhasil memuat transaksi pelanggan",
                'data' => $transaksi
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat transaksi pelanggan!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function tagihan($kode)
    {
        try {
            // Cari langganan berdasarkan kode langganan
            $langganan = Cache::remember('tagihan', 60*60*60, function() use ($kode){
                return Langganan::with('produk', 'pelanggan')->where('kode_langganan', $kode)->first();
            });
            if ($langganan == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal membuat transaksi!',
                    'errors' => ['Langganan tidak ditemukan!']
                ], Response::HTTP_NOT_FOUND);
            }elseif ($langganan->pelanggan->id_pelanggan != auth('pelanggan')->id()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal membuat transaksi!',
                    'errors' => ['Anda tidak dapat mengakses halaman!']
                ], Response::HTTP_UNAUTHORIZED);
            }
            $detail_transaksi = new DetailTransaction($langganan->pelanggan->id_pelanggan);
            $tagihan = $detail_transaksi->getInvoice($langganan);
            return response()->json([
                'status' => true,
                'message' => "Berhasil memuat tagihan langganan",
                'data' => $tagihan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat transaksi pelanggan!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function detail_transaksi($id_transaksi)
    {
        try {
            $transaksi = Transaksi::with('langganan.pelanggan', 'detail_transaksi')->findOrFail($id_transaksi);
            if ($transaksi->langganan->pelanggan->id_pelanggan != auth('pelanggan')->id()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal memuat detail transaksi!',
                    'errors' => ['Anda tidak dapat mengakses halaman!']
                ], Response::HTTP_UNAUTHORIZED);
            }
            $detail_transaksi = $transaksi->detail_transaksi;
            return response()->json([
                'status' => true,
                'message' => "Berhasil memuat transaksi pelanggan",
                'data' => $detail_transaksi
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat transaksi pelanggan!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function buat_transaksi(BankTransfer $bankTransfer, Request $request, $kode)
    {
        // Cari langganan berdasarkan kode langganan
        $langganan = Langganan::with('produk', 'pelanggan', 'transaksi', 'detail_langganan')->where('kode_langganan', $kode)->first();
        // Kalau langganan tidak ditemukan
        if ($langganan == null) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat transaksi!',
                'errors' => ['Langganan tidak ditemukan!']
            ], Response::HTTP_NOT_FOUND);
        }
        // Kalau langganan bukan milik pelanggan yang memegang token
        elseif ($langganan->pelanggan->id_pelanggan != auth('pelanggan')->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat transaksi!',
                'errors' => ['Anda tidak dapat mengakses halaman!']
            ], Response::HTTP_UNAUTHORIZED);
        }
        // Kalau langganan memiliki transaksi yang sedang berjalan
        $cekTrx = $langganan->transaksi->where('status_transaksi', 'pending');
        if ($cekTrx->count() > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat transaksi!',
                'errors' => ['Anda memiliki transaksi yang masih berjalan!']
            ], Response::HTTP_BAD_GATEWAY);
        }
        // Cari detail langganan berdasarkan langganan dan status
        $detail = $langganan->detail_langganan->where('status', 'a')->first();
        if ($detail == null) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat transaksi!',
                'errors' => ['Detail langganan tidak ditemukan!']
            ], Response::HTTP_NOT_FOUND);
        }
        // Kalau status pembayaran lunas
        if ($detail->status_pembayaran == 'l') {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat transaksi!',
                'errors' => ['Langganan anda sudah lunas!']
            ], Response::HTTP_BAD_GATEWAY);
        }
        // Kalau tanggal kadaluarsa lebih besar dari sekarang
        elseif (Carbon::parse($detail->tanggal_kadaluarsa) >= Carbon::now('+0700')) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat transaksi!',
                'errors' => ['Langganan belum kadaluarsa!']
            ], Response::HTTP_BAD_REQUEST);
        }
        // Validasi request dan custom message error
        $request->validate([
            'jumlah_tagihan' => 'required|numeric|min:1|max:' . $detail->sisa_tagihan,
            'metode_bayar' => 'required'
        ], [
            'jumlah_tagihan.required' => 'Tagihan tidak boleh kosong!',
            'jumlah_tagihan.numeric' => 'Tagihan harus berupa angka!',
            'jumlah_tagihan.min' => 'Tagihan tidak boleh lebih kecil dari 1!',
            'jumlah_tagihan.max' => 'Tagihan tidak boleh lebih besar dari ' . $detail->sisa_tagihan . '!',
            'metode_bayar.required' => 'Metode pembayaran tidak boleh kosong!'
        ]);
        try {
            $detailInvoice = new DetailTransaction($langganan->pelanggan->id_pelanggan);
            // Cari metode berdasarkan id request nya
            $metode = MetodePembayaran::where('id_metode_pembayaran', $request->metode_bayar)->firstOrFail();
            $resDetailInvoice = $detailInvoice->getDetailTransaction($langganan, $langganan->pelanggan, $request->jumlah_tagihan);

            // ============================> Charge Midtrans <============================
            // Push ke midtrans dan masukan response ke $res
            if ($metode->via == 'echannel' || $metode->via == 'permata') {
                $res = $bankTransfer->bank2($resDetailInvoice['total'], $metode->via, $resDetailInvoice['items'], $resDetailInvoice['user']);
            }else {
                $res = $bankTransfer->bank1($resDetailInvoice['total'], $metode->via, $resDetailInvoice['items'], $resDetailInvoice['user']);
            }
            // Push ke table transaksi
            $transaksi = Transaksi::create([
                'id_transaksi' => $res['order_id'],
                'id_metode_pembayaran' => $metode->id_metode_pembayaran,
                'id_langganan' => $langganan->id_langganan,
                'id_petugas' => $metode->via != 'admin' ? null : auth()->id(),
                'kode_pesanan' => $res['transaction_id'],
                'kode_toko' => $res['merchant_id'],
                'total_bayar' => $res['gross_amount'],
                'nomor_va' => $metode->via == 'admin' ? null : $res['va_numbers'][0]['va_number'],
                'status_transaksi' => $res['transaction_status'],
                'status_fraud' => $res['fraud_status'],
                'tanggal_transaksi' => Carbon::parse($res['transaction_time']),
                'tanggal_lunas' => $metode->via == 'admin' ? null : Carbon::parse($res['transaction_time'])
            ]);
            foreach ($resDetailInvoice['detail'] as $jenis) {
                $check = DB::table('detail_transaksi')->select(DB::raw('MAX(RIGHT(id_detail_transaksi, 6)) AS kode'));
                if ($check->count() > 0) {
                    foreach ($check->get() as $c) {
                        $temp = ((int) $c->kode) + 1;
                        $code = sprintf("%'.06d", $temp);
                    }
                } else {
                    $code = "000001";
                }
                // Push data ke tabel detail transaksi
                DetailTransaksi::create([
                    'id_detail_transaksi' => 'DT' . $code,
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_jenis_pembayaran' => $jenis['id_jenis_pembayaran'],
                    'harga' => $jenis['harga'],
                    'qty' => $jenis['qty'],
                    'total_tanggungan' => $jenis['total_tanggungan'],
                    'keterangan' => $jenis['keterangan']
                ]);
            }
            if ($resDetailInvoice['bermitra'] != false) {
                $check3 = DB::table('dana_mitra')->select(DB::raw('MAX(RIGHT(id_dana_mitra, 6)) AS kode'));
                if ($check3->count() > 0) {
                    foreach ($check3->get() as $c) {
                        $temp = ((int) $c->kode) + 1;
                        $code = sprintf("%'.06d", $temp);
                    }
                } else {
                    $code = "000001";
                }
                DanaMitra::create([
                    'id_dana_mitra' => 'DMIT' . $code,
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_detail_bagi_hasil' => $resDetailInvoice['bermitra']['id_bagi_hasil'],
                    'hasil_dana_mitra' => $resDetailInvoice['bermitra']['dana_mitra']
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => "Transaksi berhasil dibuat! Silakan lakukan pembayaran!"
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat transaksi pelanggan!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function transaksi_berjalan()
    {
        try {
            $data = [];
            $langganan = Cache::remember('transaksi-berjalan', 60*60*60, function(){
                return auth('pelanggan')->user()->langganan->load('transaksi.metode_pembayaran');
            });
            foreach ($langganan as $l) {
                $transaksi = $l->transaksi->load('detail_transaksi')->map(function($trx){
                    $trx->metode_pembayaran->logo = url($trx->metode_pembayaran->logo);
                    return $trx;
                });
                foreach ($transaksi as $trx) {
                    if ($trx->status_transaksi == 'pending') {
                        array_push($data, $trx);
                    }
                }
            }
            return response()->json([
                'status' => true,
                'message' => "Berhasil memuat transaksi pelanggan yang sedang berjalan!",
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat transaksi pelanggan!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function metode_bayar()
    {
        try {
            $metode = MetodePembayaran::where('status', 'a')->where('via', '!=', 'admin')->get()->map(function($m){
                $m->logo = url($m->logo);
                return $m;
            });
            return response()->json([
                'status' => true,
                'message' => "Berhasil memuat metode pembayaran!",
                'data' => $metode
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat metode pembayaran!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
    public function total(Request $request, $kode)
    {
        $margin = DB::table('pengaturan_pembayaran')->select('harga_margin')->first();
        $langganan = DB::table('langganan')
                        ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                        ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                        ->select('tanggal_instalasi', 'pelanggan.id_pelanggan')
                        ->selectRaw('produk.harga + ? AS withmargin', [$margin->harga_margin])
                        ->where('langganan.kode_langganan', $kode)
                        ->first();
        $jenis_bayar = DB::table('jenis_pembayaran')->select('harga', 'jenis_biaya')->where('status', 'a')->get();
        $totalHarga = 0;
        $langganan->tanggal_instalasi == null ? $index = 0 : $index = 1;
        foreach ($jenis_bayar as $key => $jenis) {
            if ($key >= $index) {
                if ($jenis->jenis_biaya == 'f') {
                    $totalHarga += $jenis->harga;
                }
                else {
                    $x = $jenis->harga / 100 * $langganan->withmargin;
                    $totalHarga += $x;
                }
            }
        }
        // return response()->json([$langganan->withmargin]);
        $a = $langganan->withmargin * $request->tagihan;
        $totalHarga += $a;
        $b = 0;
        $detail_mitra = DB::table('detail_mitra_pelanggan')->where('id_pelanggan', $langganan->id_pelanggan)->where('status', 'a')->first();
        if ($detail_mitra != null) {
            $biaya_mitra = DetailBagiHasil::with('pengaturan_bagi_hasil', 'mitra')->where('id_mitra', $detail_mitra->id_mitra)->where('status', 'a')->first();
            if ($biaya_mitra !== null) {
                if ($biaya_mitra->pengaturan_bagi_hasil->status_jenis == 'f') {
                    $b += $biaya_mitra->pengaturan_bagi_hasil->besaran;
                }
                else {
                    $x = $biaya_mitra->pengaturan_bagi_hasil->besaran / 100 * $langganan->withmargin;
                    $b += $x;
                }
            }
        }
        $totalHarga += $b;
        return response()->json($totalHarga);

    }
}
