<?php

namespace App\Observers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Cache;

class TransaksiObserver
{
    public function created(Transaksi $transaksi)
    {
        Cache::forget('transaksi-index');
        Cache::forget('transaksi-berjalan');
        Cache::forget('langganan');
        Cache::forget('buat-transaksi');
        Cache::forget('langganan-transaksi-langganan');
    }
    public function updated(Transaksi $transaksi)
    {
        Cache::forget('transaksi-index');
        Cache::forget('transaksi-berjalan');
        Cache::forget('langganan');
        Cache::forget('buat-transaksi');
        Cache::forget('langganan-transaksi-langganan');
    }
    public function deleted(Transaksi $transaksi)
    {
        Cache::forget('transaksi-index');
        Cache::forget('transaksi-berjalan');
        Cache::forget('langganan');
        Cache::forget('buat-transaksi');
        Cache::forget('langganan-transaksi-langganan');
    }
}
