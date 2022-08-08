<?php

namespace App\Http\Controllers\Api\Pelanggan;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $pelanggan = auth('pelanggan')->user()->load('langganan.detail_langganan');
            $data = [];
            $data['langganan_aktif'] = $pelanggan->langganan->where('status', 'a')->count();
            $data['langganan_nonaktif'] = $pelanggan->langganan->where('status', 'n')->count();
            $counter = 0;
            foreach ($pelanggan->langganan as $langganan) {
                $now = Carbon::now('+0700')->format('Y-m-d');
                $counter += $langganan->detail_langganan->where('status', 'a')->where('tanggal_kadaluarsa', '<', $now)->count();
            }
            $data['langganan_kadaluarsa'] = $counter;
            return $data;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
