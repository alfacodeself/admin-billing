<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Langganan;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DetailLangganan;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\DB;
use App\Http\Midtrans\BankTransfer;
use App\Http\Price\DetailTransaction;
use App\Models\DetailBagiHasil;
use App\Models\DetailTransaksi;
use Symfony\Component\HttpFoundation\Response;

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
                $langganan = Langganan::with('desa.kecamatan.kabupaten.provinsi','produk.kategori', 'pelanggan', 'transaksi.petugas')->where('kode_langganan', $kode)->firstOrFail();
                $tagihan = new DetailTransaction($langganan->pelanggan->id_pelanggan);
                $tagihan = $tagihan->getInvoice($langganan);
                $detail_langganan = DB::table('detail_langganan')->where('status', 'a')->where('id_langganan', $langganan->id_langganan)->first();
                $metode_bayar = DB::table('metode_pembayaran')->where('status', 'a')->get();
                return view('app.transaksi.create', compact('langganan', 'tagihan', 'metode_bayar', 'detail_langganan'));
            } catch (\Throwable $e) {
                return redirect()->route('transaksi.create')->with('danger', 'Data langganan tidak ditemukan! ' . $e->getMessage());
            }
        }
        return view('app.transaksi.create');
    }
    public function store(Request $request, $kode)
    {
        // Cari langganan berdasarkan kode langganan
        $langganan = Langganan::with('produk', 'pelanggan')->where('kode_langganan', $kode)->firstOrFail();
        $cekTrx = $langganan->transaksi->where('status_transaksi', 'pending');
        if ($cekTrx->count() > 0) {
            return redirect()->back()->with('warning', 'Anda memiliki transaksi yang masih berjalan');
        }
        // Cari detail langganan berdasarkan langganan dan status
        $detail = DetailLangganan::where('id_langganan', $langganan->id_langganan)->where('status', 'a')->firstOrFail();
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
            // Inisialisasikan class baru
            $payment = new BankTransfer();
            $detailInvoice = new DetailTransaction($langganan->pelanggan->id_pelanggan);

            // Cari metode berdasarkan id request nya
            $metode = MetodePembayaran::where('id_metode_pembayaran', $request->metode_bayar)->firstOrFail();
            $resDetailInvoice = $detailInvoice->getDetailTransaction($langganan, $langganan->pelanggan, $request->jumlah_tagihan);
            // ============================> Charge Midtrans <============================
            // Push ke midtrans dan masukan response ke $res
            if ($metode->via == 'echannel' || $metode->via == 'permata') {
                $res = $payment->bank2($resDetailInvoice['total'], $metode->via, $resDetailInvoice['items'], $resDetailInvoice['user']);
            }elseif ($metode->via == 'admin') {
                $res = $payment->billing($resDetailInvoice['total'], $langganan, $request->jumlah_tagihan);
            }else {
                $res = $payment->bank1($resDetailInvoice['total'], $metode->via, $resDetailInvoice['items'], $resDetailInvoice['user']);
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
            return redirect()->route('transaksi.index')->with('success', 'Berhasil membuat transaksi!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', 'Gagal membuat transaksi!' . $th->getMessage());
        }
    }
    public function show($id)
    {
        $detail_transaksi = DetailTransaksi::with('transaksi', 'jenis_pembayaran')->where('id_transaksi', $id)->get();
        return view('app.transaksi.show', compact('detail_transaksi'));
    }
    public function notification(Request $request)
    {
        try {
            // Ambil pengaturan server key midtrans
            $setting = DB::table('pengaturan_pembayaran')->select('server_key')->first();
            // Inisialisasi req content
            $notifBody = json_decode($request->getContent());
            // Buat signature key berdasarkan server key
            $signature_key = hash('sha512', $notifBody->order_id . $notifBody->status_code . $notifBody->gross_amount . $setting->server_key);
            // Validasi kecocokan server key
            if ($signature_key != $notifBody->signature_key) {
                return response()->json([
                    "status" => false,
                    "message" => "Transaksi Invalid",
                    "errors" => "Signature key tidak cocok!"
                ]);
            }
            // Inisial variabel status transaksi
            $transaction_status = $notifBody->transaction_status;
            // Cari order berdasarkan id transaksi dan id pesanan
            $order = Transaksi::with('detail_transaksi', 'langganan')
                ->where('id_transaksi', $notifBody->order_id)
                ->where('kode_pesanan', $notifBody->transaction_id)
                ->firstOrFail();
            // Inisial detail langganan untuk mengupdate data yang diperlukan ketika transaksi dilakukan
            $detail_langganan = DetailLangganan::where('id_langganan', $order->id_langganan)
                ->where('status', 'a')
                ->where('status_pembayaran', 'bl')
                ->firstOrFail();
            // Inisial quantity dari detail transaksi yang telah dibuat
            $qty = $order->detail_transaksi->whereNull('id_jenis_pembayaran')->first()['qty'];
            // Kalau status transaksi dari req beda dengan status transaksi dari transaksi
            if ($transaction_status !== $order->status_transaksi) {
                // Update status transaksi
                $order->update(['status_transaksi' => $transaction_status]);
                // Kalau status transaksi dari req settlement
                if ($transaction_status == 'settlement') {
                    $order->update(['tanggal_lunas' => $notifBody->settlement_time]);
                    // Inisialisasikan sisa tagihan dikurang qty pembelian dari transaksi
                    $sisa_tagihan = $detail_langganan->sisa_tagihan - $qty;
                    // Kalau sisa tagihan = 0 maka status detail tagihan menjadi lunas. Kalau tidak maka belum lunas
                    $status_bayar = $sisa_tagihan == 0 ? 'l' : 'bl';
                    // Kalau tanggal instalasi belum ada maka tidak mengupdate kadaluarsa dan tanggal selesai karena langganan belum di mulai
                    if ($order->langganan->tanggal_instalasi == null) {
                        $data = [
                            'sisa_tagihan' => $sisa_tagihan,
                            'status_pembayaran' => $status_bayar
                        ];
                        $order->langganan->update([
                            'status' => 'pni',
                            'histori' => $order->langganan->histori . '|Pengajuan Instalasi',
                            'pesan' => 'Berhasil melakukan pembayaran! Silakan ajukan tanggal pemasangan instalasi!'
                        ]);
                    }
                    // Kalau sudah melakukan instalasi, maka update tanggal kadaluarsa
                    else {
                        // Inisial tanggal selesai dari tabel detail langganan
                        $tgl_selesai = Carbon::parse($detail_langganan->tanggal_selesai);
                        // Inisial tanggal kadaluarsa berdasarkan quantity transaksi
                        $tgl_expired = Carbon::now()->addMonths($qty);
                        // Kalau tanggal expired lebih besar dari tanggal selesai dan status berlangganan nya false
                        if ($tgl_selesai < $tgl_expired && !$detail_langganan->jenis_langganan->status_berlangganan) {
                            // Update tanggal selesai sama dengan expired
                            $tgl_selesai = $tgl_expired;
                        }
                        // Kalau tanggal expired tidak lebih dari tanggal selesai atau status berlangganannya true
                        // Tanggal selesai tidak diubah
                        $data = [
                            'tanggal_kadaluarsa' => $tgl_expired,
                            'tanggal_selesai' => $tgl_selesai,
                            'sisa_tagihan' => $sisa_tagihan,
                            'status_pembayaran' => $status_bayar
                        ];
                    }
                    // Update detail langganan
                    $detail_langganan->update($data);
                    return $request->expectsJson()
                        ? response()->json([
                            "status" => true,
                            "message" => "Transaksi berhasil! Langganan telah di perbarui!",
                            "sisa" => [
                                'sisa_tagihan' => $detail_langganan->sisa_tagihan,
                            ]
                        ], Response::HTTP_CREATED, ['Accept' => 'application/json'])
                        : redirect()->back()->with('success', 'Transaksi berhasil! Langganan telah di perbarui!');
                }
            }
        } catch (\Throwable $e) {
            return $request->expectsJson()
                ? response()->json([
                    "status" => false,
                    "message" => "Transaksi Gagal! Langganan gagal di perbarui!",
                    "errors" => $e->getMessage()
                ], Response::HTTP_BAD_REQUEST, ['Accept' => 'application/json'])
                : redirect()->back()->with('danger', 'Transaksi Gagal! Langganan gagal di perbarui! ' . $e->getMessage());
        }
    }
}
