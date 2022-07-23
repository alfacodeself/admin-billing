<?php

namespace App\Http\Midtrans;

use Carbon\Carbon;
use GuzzleHttp\Client;
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
    public function bca($grossAmount, $bank, array $itemDetails, array $customerDetails)
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
}
