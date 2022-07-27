<?php

namespace App\Http\Midtrans;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Langganan;
use Illuminate\Support\Str;
use App\Models\DetailLangganan;
use Illuminate\Support\Facades\DB;

class BankTransfer {
    private $settings;
    private $idTransaction;
    private $orderTime;
    private $http;

    function __construct(){
        $this->settings = DB::table('pengaturan_pembayaran')->first();
        $this->idTransaction = "TRX-" . time();
        $this->orderTime = Carbon::parse(date_create(now('+0700')))->toDateTimeString() . ' +0700';
        $this->http = new Client();
    }
    public function bank1($grossAmount, $bank, array $itemDetails, array $customerDetails)
    {
        $data = $this->http->post($this->settings->charge_url, [
            'headers'   =>  [
                'Accept'        =>  'application/json',
                'Authorization' =>  'Basic '. base64_encode($this->settings->server_key) . ':',
                'Content-Type'  =>  'application/json'
            ],
            'body'  =>  json_encode([
                'payment_type'  =>  'bank_transfer',
                'transaction_details'   =>  [
                    'order_id'  =>  $this->idTransaction,
                    'gross_amount'  =>  $grossAmount
                ],
                'bank_transfer' =>  [
                    'bank'  =>  $bank
                ],
                'item_details'  =>  $itemDetails,
                'customer_details'  =>  $customerDetails,
                'custom_expiry' =>  [
                    'order_time'    =>  $this->orderTime,
                    'expiry_duration'   =>  $this->settings->durasi_waktu,
                    'expiry_unit'   =>  $this->settings->satuan_durasi
                ]
            ])
        ]);
        return json_decode($data->getBody(), true);
    }
    public function bank2($grossAmount, $bank, array $itemDetails, array $customerDetails)
    {
        $data = $this->http->post($this->settings->charge_url, [
            'headers'   =>  [
                'Accept'        =>  'application/json',
                'Authorization' =>  'Basic '. base64_encode($this->settings->server_key) . ':',
                'Content-Type'  =>  'application/json'
            ],
            'body'  =>  json_encode([
                'payment_type'  =>  $bank,
                'transaction_details'   =>  [
                    'order_id'  =>  $this->idTransaction,
                    'gross_amount'  =>  $grossAmount
                ],
                'item_details'  =>  $itemDetails,
                'customer_details'  =>  $customerDetails,
                'custom_expiry' =>  [
                    'order_time'    =>  $this->orderTime,
                    'expiry_duration'   =>  $this->settings->durasi_waktu,
                    'expiry_unit'   =>  $this->settings->satuan_durasi
                ]
            ])
        ]);
        return json_decode($data->getBody(), true);
    }
    public function billing($grossAmount, Langganan $langganan, $qty)
    {
        $detail_langganan = DetailLangganan::where('id_langganan', $langganan->id_langganan)
                ->where('status', 'a')
                ->where('status_pembayaran', 'bl')
                ->firstOrFail();
        $sisa_tagihan = $detail_langganan->sisa_tagihan - $qty;
        // Kalau sisa tagihan = 0 maka status detail tagihan menjadi lunas. Kalau tidak maka belum lunas
        $status_bayar = $sisa_tagihan == 0 ? 'l' : 'bl';
        // Kalau tanggal instalasi belum ada maka tidak mengupdate kadaluarsa dan tanggal selesai karena langganan belum di mulai
        if ($langganan->tanggal_instalasi == null) {
            $data = [
                'sisa_tagihan' => $sisa_tagihan,
                'status_pembayaran' => $status_bayar
            ];
            $langganan->update([
                'status' => 'pni',
                'histori' => $langganan->histori . '|Pengajuan Instalasi',
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
            if ($tgl_expired > $tgl_selesai && !$detail_langganan->jenis_langganan->status_berlangganan) {
                // Update tanggal selesai sama dengan expired
                $tgl_selesai = $tgl_expired;
            }
            if ($tgl_expired > $tgl_selesai && $detail_langganan->jenis_langganan->status_berlangganan) {
                $tgl_expired = $tgl_selesai;
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
        $data =  [
            'order_id' => $this->idTransaction,
            'gross_amount' => $grossAmount,
            'transaction_id' => Str::uuid(),
            'merchant_id' => 'G' . Str::upper(Str::random(5)),
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
            'transaction_time' => Carbon::now()
        ];
        return $data;
    }
}
