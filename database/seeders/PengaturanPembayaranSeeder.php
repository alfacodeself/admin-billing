<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaturanPembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('INSERT INTO pengaturan_pembayaran VALUE (?,?,?,?,?,?,?)', [
            'PP001',
            'SB-Mid-server-05GjX4C1v6VWTy45bLo4YtAc',
            'SB-Mid-client-GmZa_8UDvpdh0rwZ',
            'https://api.sandbox.midtrans.com/v2/charge',
            '1',
            'hour',
            20000
        ]);
    }
}
