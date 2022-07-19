<?php

namespace Database\Seeders;

use App\Models\MetodePembayaran;
use Illuminate\Database\Seeder;

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MetodePembayaran::create([
            'id_metode_pembayaran'  =>  'MP0001',
            'logo'                  =>  '/storage/bank/bca.png',
            'metode_pembayaran'     =>  'Bank Transfer',
            'via'                   =>  'bca',
            'status'                =>  'a'
        ]);
        MetodePembayaran::create([
            'id_metode_pembayaran'  =>  'MP0002',
            'logo'                  =>  '/storage/bank/bni.png',
            'metode_pembayaran'     =>  'Bank Transfer',
            'via'                   =>  'bni',
            'status'                =>  'a'
        ]);
        MetodePembayaran::create([
            'id_metode_pembayaran'  =>  'MP0003',
            'logo'                  =>  '/storage/bank/bri.png',
            'metode_pembayaran'     =>  'Bank Transfer',
            'via'                   =>  'bri',
            'status'                =>  'a'
        ]);
        MetodePembayaran::create([
            'id_metode_pembayaran'  =>  'MP0004',
            'logo'                  =>  '/storage/bank/mandiri.png',
            'metode_pembayaran'     =>  'Bank Transfer',
            'via'                   =>  'echannel',
            'status'                =>  'a'
        ]);
        MetodePembayaran::create([
            'id_metode_pembayaran'  =>  'MP0005',
            'logo'                  =>  '/storage/bank/permata.png',
            'metode_pembayaran'     =>  'Bank Transfer',
            'via'                   =>  'permata',
            'status'                =>  'a'
        ]);
        MetodePembayaran::create([
            'id_metode_pembayaran'  =>  'MP0006',
            'logo'                  =>  '/storage/bank/gopay.png',
            'metode_pembayaran'     =>  'E Money',
            'via'                   =>  'gopay',
            'status'                =>  'a'
        ]);
        MetodePembayaran::create([
            'id_metode_pembayaran'  =>  'MP0007',
            'logo'                  =>  '/storage/bank/bcaklikpay.png',
            'metode_pembayaran'     =>  'Direct Debit',
            'via'                   =>  'bca_klikpay',
            'status'                =>  'a'
        ]);
        MetodePembayaran::create([
            'id_metode_pembayaran'  =>  'MP0008',
            'logo'                  =>  '/storage/bank/brimo.png',
            'metode_pembayaran'     =>  'Direct Debit',
            'via'                   =>  'bri_epay',
            'status'                =>  'a'
        ]);
        MetodePembayaran::create([
            'id_metode_pembayaran'  =>  'MP0009',
            'logo'                  =>  '/storage/bank/danamon.png',
            'metode_pembayaran'     =>  'Direct Debit',
            'via'                   =>  'danamon_online',
            'status'                =>  'a'
        ]);
    }
}
