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
            // Cari metode berdasarkan id request nya
            $metode = MetodePembayaran::where('id_metode_pembayaran', $request->metode_bayar)->firstOrFail();
            // Cari data jenis pembayaran
            $jenis_bayar = DB::table('jenis_pembayaran')->select('id_jenis_pembayaran', 'jenis_pembayaran', 'harga', 'jenis_biaya')->where('status', 'a')->get();
            // Inisialisasi total
            $totalHarga = 0;
            // Inisialisasi items yang akan menampung data jenis bayar
            $items = [];
            // Buat format data pelanggan
            $user = [
                'first_name'    => $langganan->pelanggan->nama_pelanggan,
                'email'         => $langganan->pelanggan->email,
                'phone'         => $langganan->pelanggan->nomor_hp,
                'billing_address'   => [
                    'address'       => $langganan->pelanggan->alamat,
                    'postal_code'   => $langganan->pelanggan->desa->kode_pos
                ],
                'shipping_address'  => [
                    'address'       => $langganan->alamat_pemasangan,
                    'postal_code'   => $langganan->desa->kode_pos
                ]
            ];
            // Jika tanggal instalasi null maka harus membayar biaya instalasi
            $langganan->tanggal_instalasi == null ? $index = 0 : $index = 1;
            foreach ($jenis_bayar as $key => $jenis) {
                // Validasikan berdasarkan $index dari penentuan biaya instalasi
                if ($key >= $index) {
                    // Kalau tipe flat
                    if ($jenis->jenis_biaya == 'f') {
                        $harga = $jenis->harga;
                    }
                    // Kalau presentase
                    else {
                        // Harga jenis pembayaran :100 * harga langganan yang telah di margin
                        $x = $jenis->harga / 100 * $langganan->produk->withmargin;
                        $harga = $x;
                    }
                    // Push data ke variabel items
                    array_push($items, [
                        'id'        => $key + 1,
                        'price'     => $harga,
                        'quantity'  => 1,
                        'name'      => $jenis->jenis_pembayaran
                    ]);
                    // Push total harga dengan harga yang di dapat pada tiap perulangan
                    $totalHarga += $harga;
                }
            }
            // Harga produk yang sudah di margin + Tagihan yang akan dibayar
            $a = $langganan->produk->withmargin * $request->jumlah_tagihan;
            // Push Produk
            array_push($items, [
                'id'        => count($items) + 1,
                'price'     => $langganan->produk->withmargin,
                'quantity'  => $request->jumlah_tagihan,
                'name'      => $langganan->produk->nama_produk . '|' . $langganan->produk->kategori->nama_kategori,
            ]);
            // Push total dari harga produk
            $totalHarga += $a;
            // Push ke midtrans dan masukan response ke $res
            if ($metode->via == 'echannel' || $metode->via == 'permata') {
                $res = $payment->bank2($totalHarga, $metode->via, $items, $user);
            }elseif ($metode->via == 'admin') {
                $res = $payment->billing($totalHarga, $langganan, $request->jumlah_tagihan);
            }else {
                $res = $payment->bank2($totalHarga, $metode->via, $items, $user);
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
            foreach ($jenis_bayar as $key => $jenis) {
                if ($key >= $index) {
                    // Kalau tipe flat
                    if ($jenis->jenis_biaya == 'f') {
                        $harga = $jenis->harga;
                    }
                    // Kalau presentase
                    else {
                        $x = $jenis->harga / 100 * $langganan->produk->withmargin;
                        $harga = $x;
                    }
                    // Buat kode unique
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
                        'id_jenis_pembayaran' => $jenis->id_jenis_pembayaran,
                        'harga' => $harga,
                        'qty' => 1,
                        'total_tanggungan' => $harga
                    ]);
                }
            }
            // Buat lagi kode unique untuk produk
            $check = DB::table('detail_transaksi')->select(DB::raw('MAX(RIGHT(id_detail_transaksi, 6)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.06d", $temp);
                }
            } else {
                $code = "000001";
            }
            // Push data produk ke tabel detail transaksi
            DetailTransaksi::create([
                'id_detail_transaksi' => 'DT' . $code,
                'id_transaksi' => $transaksi->id_transaksi,
                'id_jenis_pembayaran' => null,
                'harga' => $langganan->produk->withmargin,
                'qty' => $request->jumlah_tagihan,
                'total_tanggungan' => $a
            ]);
            return redirect()->route('transaksi.index')->with('success', 'Berhasil membuat transaksi!');
        } catch (\Throwable $th) {
            // return $th->getMessage();
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
