<?php

namespace Database\Seeders;

use App\Models\DetailLangganan;
use App\Models\Langganan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class LanggananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $langganan = Langganan::create([
            'id_langganan' => 'L00001',
            'id_produk' => 'P001',
            'id_pelanggan' => 'PL00001',
            'kode_langganan' => Str::random(15),
            'alamat_pemasangan' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat, quam!',
            'id_desa' => 'DES001',
            'rt' => 3,
            'rw' => 1,
            'latitude' => '-7.744161632859142',
            'longitude' => '113.21582794189453',
            'status' => 'pn',
            'histori' => 'Terdaftar|Diterima'
        ]);
        DetailLangganan::create([
            'id_detail_langganan' => 'DL00001',
            'id_langganan' => $langganan->id_langganan,
            'id_jenis_langganan' => 'JL002',
            'sisa_tagihan' => 6,
            'status' => 'a',
            'status_pembayaran' => 'bl'
        ]);
    }
}
