<?php

namespace Database\Seeders;

use App\Models\JenisLangganan;
use Illuminate\Database\Seeder;

class JenisLanggananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisLangganan::create([
            'id_jenis_langganan' => 'JL001',
            'lama_berlangganan' => 'Tidak Berlangganan',
            'banyak_tagihan' => 1,
            'status' => 'a'
        ]);
        JenisLangganan::create([
            'id_jenis_langganan' => 'JL002',
            'lama_berlangganan' => '6 Bulan',
            'banyak_tagihan' => 6,
            'status' => 'a'
        ]);
        JenisLangganan::create([
            'id_jenis_langganan' => 'JL003',
            'lama_berlangganan' => '8 Bulan',
            'banyak_tagihan' => 8,
            'status' => 'a'
        ]);
        JenisLangganan::create([
            'id_jenis_langganan' => 'JL004',
            'lama_berlangganan' => '1 Tahun',
            'banyak_tagihan' => 12,
            'status' => 'a'
        ]);
    }
}
