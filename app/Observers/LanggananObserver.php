<?php

namespace App\Observers;

use App\Models\Langganan;
use Illuminate\Support\Facades\Cache;

class LanggananObserver
{
    /**
     * Handle the Langganan "created" event.
     *
     * @param  \App\Models\Langganan  $langganan
     * @return void
     */
    public function created(Langganan $langganan)
    {
        Cache::forget('langganan-index');
        Cache::forget('langganan-show');
        Cache::forget('detail-langganan-show');
        Cache::forget('semua-detail-langganan');
        Cache::forget('langganan-transaksi-langganan');
        Cache::forget('langganan-index-petugas');
    }

    /**
     * Handle the Langganan "updated" event.
     *
     * @param  \App\Models\Langganan  $langganan
     * @return void
     */
    public function updated(Langganan $langganan)
    {
        Cache::forget('langganan-index');
        Cache::forget('langganan-show');
        Cache::forget('detail-langganan-show');
        Cache::forget('semua-detail-langganan');
        Cache::forget('langganan-transaksi-langganan');
        Cache::forget('langganan-index-petugas');
    }

    /**
     * Handle the Langganan "deleted" event.
     *
     * @param  \App\Models\Langganan  $langganan
     * @return void
     */
    public function deleted(Langganan $langganan)
    {
        Cache::forget('langganan-index');
        Cache::forget('langganan-show');
        Cache::forget('detail-langganan-show');
        Cache::forget('semua-detail-langganan');
        Cache::forget('langganan-transaksi-langganan');
    }
}
